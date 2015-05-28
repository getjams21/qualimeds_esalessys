create view vwinventorysource
as
SELECT  'Bills' As SourceName, Bills.BranchNo, Branches.BranchName, 
       Bills.BillDate As TranDate, Bills.SalesInvoiceNo As RefDoc, 
        Products.ProductCatNo,  ProductCategories.ProdCatName, 
        BillDetails.ProductNo, Products.ProductName, Products.BrandName, 
        Products.ReorderPoint, BillDetails.LotNo, BillDetails.ExpiryDate, 
        BillDetails.CostPerQty,
        Case When  Products.ActiveMarkup =1  Then
           BillDetails.CostPerQty * (1 + (Products.Markup1/100.00))
           else 
              Case When Products.ActiveMarkup = 2 Then
                 BillDetails.CostPerQty * (1 + (Products.Markup2/100.00))
               else
                  BillDetails.CostPerQty * (1 + (Products.Markup3/100.00))
               end  
           end SellingPrice,
        Products.WholeSaleUnit, 
        (Case When BillDetails.Unit=Products.RetailUnit Then
              BillDetails.Qty / Products.RetailQtyPerWholeSaleUnit
            Else
               BillDetails.Qty
            End
        +
        
        Case When BillDetails.FreebiesUnit=Products.RetailUnit Then
              BillDetails.FreebiesQty / Products.RetailQtyPerWholeSaleUnit
            Else
               BillDetails.FreebiesQty
            End) As WholeSaleQty,
                   
        Products.RetailUnit,
        
        (Case When BillDetails.Unit=Products.WholeSaleUnit Then
              BillDetails.Qty * Products.RetailQtyPerWholeSaleUnit
            Else
               BillDetails.Qty 
            End 
        +
            
        Case When BillDetails.FreebiesUnit=Products.WholeSaleUnit Then
              BillDetails.FreebiesQty * Products.RetailQtyPerWholeSaleUnit
            Else
               BillDetails.FreebiesQty
            End) As RetailSaleQty          
FROM  Bills INNER JOIN BillDetails ON Bills.Id = BillDetails.BillNo INNER JOIN
Products ON BillDetails.ProductNo = Products.Id INNER JOIN
ProductCategories ON Products.ProductCatNo = ProductCategories.Id
INNER JOIN Branches ON Bills.BranchNo = Branches.Id
Where Bills.ApprovedBy <> '' and Bills.IsCancelled='N'

Union All

SELECT  'SI' As SourceName, SalesInvoices.BranchNo, Branches.BranchName,
    SalesInvoices.InvoiceDate As TranDate, SalesInvoices.SalesInvoiceRefDocNo As RefDoc, 
    Products.ProductCatNo, ProductCategories.ProdCatName, 
    SalesInvoiceDetails.ProductNo, Products.ProductName, Products.BrandName, 
  Products.ReorderPoint,
    SalesInvoiceDetails.LotNo, SalesInvoiceDetails.ExpiryDate, 0.00 As CostPerQty,
    SalesInvoiceDetails.UnitPrice As SellingPrice,
    Products.WholeSaleUnit, 
        ((Case When SalesInvoiceDetails.Unit=Products.RetailUnit Then
              SalesInvoiceDetails.Qty / Products.RetailQtyPerWholeSaleUnit
            Else
               SalesInvoiceDetails.Qty
            End
        +
        
        Case When SalesInvoiceDetails.FreebiesUnit=Products.RetailUnit Then
              SalesInvoiceDetails.FreebiesQty / Products.RetailQtyPerWholeSaleUnit
            Else
               SalesInvoiceDetails.FreebiesQty
            End) * -1 )As WholeSaleQty,
                   
    Products.RetailUnit,
        
        ((Case When SalesInvoiceDetails.Unit=Products.WholeSaleUnit Then
              SalesInvoiceDetails.Qty * Products.RetailQtyPerWholeSaleUnit
            Else
               SalesInvoiceDetails.Qty 
            End 
        +
            
        Case When SalesInvoiceDetails.FreebiesUnit=Products.WholeSaleUnit Then
              SalesInvoiceDetails.FreebiesQty * Products.RetailQtyPerWholeSaleUnit
            Else
               SalesInvoiceDetails.FreebiesQty
            End) * -1) As RetailSaleQty          
FROM SalesInvoices INNER JOIN SalesInvoiceDetails 
ON SalesInvoices.Id = SalesInvoiceDetails.SalesInvoiceNo 
INNER JOIN Products ON SalesInvoiceDetails.ProductNo = Products.Id 
INNER JOIN ProductCategories ON Products.ProductCatNo = ProductCategories.Id
INNER JOIN Branches ON SalesInvoices.BranchNo = Branches.Id
Where SalesInvoices.IsCancelled='N'

Union All

SELECT 'SupplierReturns 'As SourceName, SupplierReturns.BranchNo, Branches.BranchName,
    SupplierReturns.ReturnDate As TranDate, 
    Bills.SalesInvoiceNo As RefDoc, Products.ProductCatNo, ProductCategories.ProdCatName, 
    Products.Id, Products.ProductName, Products.BrandName, Products.ReorderPoint,
   SupplierReturnDetails.LotNo, 
    SupplierReturnDetails.ExpiryDate, SupplierReturnDetails.CostPerQty, 0.00 As SellingPrice,
    Products.WholeSaleUnit, 
        ((Case When SupplierReturnDetails.Unit=Products.RetailUnit Then
              SupplierReturnDetails.Qty / Products.RetailQtyPerWholeSaleUnit
            Else
               SupplierReturnDetails.Qty
            End
        +
        
        Case When SupplierReturnDetails.FreebiesUnit=Products.RetailUnit Then
              SupplierReturnDetails.FreebiesQty / Products.RetailQtyPerWholeSaleUnit
            Else
               SupplierReturnDetails.FreebiesQty
            End) * -1 )As WholeSaleQty,
                   
    Products.RetailUnit,
        
        ((Case When SupplierReturnDetails.Unit=Products.WholeSaleUnit Then
              SupplierReturnDetails.Qty * Products.RetailQtyPerWholeSaleUnit
            Else
               SupplierReturnDetails.Qty 
            End 
        +
            
        Case When SupplierReturnDetails.FreebiesUnit=Products.WholeSaleUnit Then
              SupplierReturnDetails.FreebiesQty * Products.RetailQtyPerWholeSaleUnit
            Else
               SupplierReturnDetails.FreebiesQty
            End) * -1) As RetailSaleQty              
FROM SupplierReturns INNER JOIN SupplierReturnDetails 
ON SupplierReturns.Id = SupplierReturnDetails.SupplierReturnNo 
INNER JOIN Products ON SupplierReturnDetails.ProductNo = Products.Id 
INNER JOIN ProductCategories ON Products.ProductCatNo = ProductCategories.Id 
INNER JOIN Bills ON SupplierReturns.BillNo = Bills.Id
INNER JOIN Branches ON SupplierReturns.BranchNo = Branches.Id
Where SupplierReturns.ApprovedBy<>''  And SupplierReturns.IsCancelled='N'

Union All

SELECT 'CustomerReturns' As SourceName, CustomerReturns.BranchNo, Branches.BranchName,
   CustomerReturns.CustomerReturnDate As TranDate, 
   CustomerReturns.SalesinvoiceNo  As RefDoc, Products.ProductCatNo, ProductCategories.ProdCatName, 
   Products.Id, Products.ProductName, Products.BrandName, 
Products.ReorderPoint, CustomerReturnDetails.LotNo, 
   CustomerReturnDetails.ExpiryDate, 0.00 CostPerQty, CustomerReturnDetails.UnitPrice As SellingPrice, 
    Products.WholeSaleUnit, 
        (Case When CustomerReturnDetails.Unit=Products.RetailUnit Then
              CustomerReturnDetails.Qty / Products.RetailQtyPerWholeSaleUnit
            Else
               CustomerReturnDetails.Qty
            End
        +
        
        Case When CustomerReturnDetails.FreebiesUnit=Products.RetailUnit Then
              CustomerReturnDetails.FreebiesQty / Products.RetailQtyPerWholeSaleUnit
            Else
               CustomerReturnDetails.FreebiesQty
            End) As WholeSaleQty,
                   
    Products.RetailUnit,
        
        (Case When CustomerReturnDetails.Unit=Products.WholeSaleUnit Then
              CustomerReturnDetails.Qty * Products.RetailQtyPerWholeSaleUnit
            Else
               CustomerReturnDetails.Qty 
            End 
        +
            
        Case When CustomerReturnDetails.FreebiesUnit=Products.WholeSaleUnit Then
              CustomerReturnDetails.FreebiesQty * Products.RetailQtyPerWholeSaleUnit
            Else
               CustomerReturnDetails.FreebiesQty
            End) As RetailSaleQty                                 
FROM CustomerReturns INNER JOIN CustomerReturnDetails 
ON CustomerReturns.Id = CustomerReturnDetails.CustomerReturnNo 
INNER JOIN Products ON CustomerReturnDetails.ProductNo = Products.Id 
INNER JOIN ProductCategories ON Products.ProductCatNo = ProductCategories.Id
INNER JOIN Branches ON CustomerReturns.BranchNo = Branches.Id
Where CustomerReturns.ApprovedBy<>''  And CustomerReturns.IsCancelled='N'

Union All

SELECT 'InvAdjustment' As SourceName, InventoryAdjustments.BranchNo, Branches.BranchName,
   InventoryAdjustments.AdjustmentDate As TranDate, 
   InventoryAdjustments.Id As RefDoc, Products.ProductCatNo, ProductCategories.ProdCatName, 
   InventoryAdjustmentDetails.ProductNo, Products.ProductName, 
    Products.BrandName, Products.ReorderPoint,
   InventoryAdjustmentDetails.LotNo, InventoryAdjustmentDetails.ExpiryDate, InventoryAdjustmentDetails.CostPerQty,
   0.00 As SellingPrice, 
    Products.WholeSaleUnit, 
        (Case When InventoryAdjustmentDetails.Unit=Products.RetailUnit Then
              InventoryAdjustmentDetails.Qty / Products.RetailQtyPerWholeSaleUnit
            Else
               InventoryAdjustmentDetails.Qty
            End) As WholeSaleQty,
                   
    Products.RetailUnit,
        
        (Case When InventoryAdjustmentDetails.Unit=Products.WholeSaleUnit Then
              InventoryAdjustmentDetails.Qty * Products.RetailQtyPerWholeSaleUnit
            Else
               InventoryAdjustmentDetails.Qty 
            End) As RetailSaleQty                                    
FROM InventoryAdjustments INNER JOIN InventoryAdjustmentDetails 
ON InventoryAdjustments.Id = InventoryAdjustmentDetails.InvAdjustmentNo 
INNER JOIN Products ON InventoryAdjustmentDetails.ProductNo = Products.Id 
INNER JOIN ProductCategories ON Products.ProductCatNo = ProductCategories.Id
INNER JOIN Branches ON InventoryAdjustments.BranchNo = Branches.Id
Where InventoryAdjustments.ApprovedBy<>''  And InventoryAdjustments.IsCancelled='N'

Union All

SELECT 'InvDamages' As SourceName, InventoryDamages.BranchNo, Branches.BranchName,
   InventoryDamages.InvDamageDate As TranDate, InventoryDamages.Id As RefDoc, 
   Products.ProductCatNo, ProductCategories.ProdCatName, 
   InventoryDamageDetails.ProductNo, Products.ProductName, 
  Products.BrandName,  Products.ReorderPoint,
   InventoryDamageDetails.LotNo, InventoryDamageDetails.ExpiryDate, InventoryDamageDetails.CostPerQty,
    0.00 As SellingPrice, 
    Products.WholeSaleUnit, 
        ((Case When InventoryDamageDetails.Unit=Products.RetailUnit Then
              InventoryDamageDetails.Qty / Products.RetailQtyPerWholeSaleUnit
            Else
               InventoryDamageDetails.Qty
            End) * -1) As WholeSaleQty,
                   
    Products.RetailUnit,
        
        ((Case When InventoryDamageDetails.Unit=Products.WholeSaleUnit Then
              InventoryDamageDetails.Qty * Products.RetailQtyPerWholeSaleUnit
            Else
               InventoryDamageDetails.Qty 
            End) * -1) As RetailSaleQty                                        
FROM InventoryDamages INNER JOIN InventoryDamageDetails 
ON InventoryDamages.Id = InventoryDamageDetails.InvDamagesNo 
INNER JOIN Products ON InventoryDamageDetails.ProductNo = Products.Id 
INNER JOIN ProductCategories ON Products.ProductCatNo = ProductCategories.Id
INNER JOIN Branches ON InventoryDamages.BranchNo = Branches.Id
Where InventoryDamages.ApprovedBy<>''  And InventoryDamages.IsCancelled='N'

Union All

SELECT 'StockTransferOut' As SourceName, StockTransfers.BranchSourceNo As BranchNo, Branches.BranchName, 
  StockTransfers.TransferDate As TranDate, StockTransfers.Id As RefDoc, 
  Products.ProductCatNo, ProductCategories.ProdCatName, StockTransferDetails.ProductNo, 
  Products.ProductName, Products.BrandName, Products.ReorderPoint,
  StockTransferDetails.LotNo, StockTransferDetails.ExpiryDate, 
  StockTransferDetails.CostPerUnit, 0.00 As SellingPrice, 
    Products.WholeSaleUnit, 
        ((Case When StockTransferDetails.Unit=Products.RetailUnit Then
              StockTransferDetails.Qty / Products.RetailQtyPerWholeSaleUnit
            Else
               StockTransferDetails.Qty
            End) * -1) As WholeSaleQty,
                   
    Products.RetailUnit,
        
        ((Case When StockTransferDetails.Unit=Products.WholeSaleUnit Then
              StockTransferDetails.Qty * Products.RetailQtyPerWholeSaleUnit
            Else
               StockTransferDetails.Qty 
            End) * -1) As RetailSaleQty                                        
FROM StockTransfers INNER JOIN StockTransferDetails 
ON StockTransfers.Id = StockTransferDetails.StockTransferNo 
INNER JOIN Products ON StockTransferDetails.ProductNo = Products.Id 
INNER JOIN ProductCategories ON Products.ProductCatNo = ProductCategories.Id 
INNER JOIN Branches ON StockTransfers.BranchSourceNo = Branches.Id
Where StockTransfers.ApprovedBy<>''  And StockTransfers.IsCancelled='N'

Union All

SELECT 'StockTransferIn' As SourceName, StockTransfers.BranchDestinationNo As BranchNo, Branches.BranchName, 
  StockTransfers.TransferDate As TranDate, StockTransfers.Id As RefDoc, 
  Products.ProductCatNo, ProductCategories.ProdCatName, StockTransferDetails.ProductNo, 
  Products.ProductName, Products.BrandName, Products.ReorderPoint,
 StockTransferDetails.LotNo, StockTransferDetails.ExpiryDate, 
  StockTransferDetails.CostPerUnit, 0.00 As SellingPrice, 
     Products.WholeSaleUnit, 
        (Case When StockTransferDetails.Unit=Products.RetailUnit Then
              StockTransferDetails.Qty / Products.RetailQtyPerWholeSaleUnit
            Else
               StockTransferDetails.Qty
            End) As WholeSaleQty,
                   
    Products.RetailUnit,
        
        (Case When StockTransferDetails.Unit=Products.WholeSaleUnit Then
              StockTransferDetails.Qty * Products.RetailQtyPerWholeSaleUnit
            Else
               StockTransferDetails.Qty 
            End) As RetailSaleQty                                        
FROM StockTransfers INNER JOIN StockTransferDetails 
ON StockTransfers.Id = StockTransferDetails.StockTransferNo 
INNER JOIN Products ON StockTransferDetails.ProductNo = Products.Id
INNER JOIN ProductCategories ON Products.ProductCatNo = ProductCategories.Id 
INNER JOIN Branches ON StockTransfers.BranchDestinationNo = Branches.Id
Where StockTransfers.ApprovedBy<>''  And StockTransfers.IsCancelled='N'