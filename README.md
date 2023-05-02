
## Simple export
https://docs.laravel-excel.com/3.1/exports/export-formats.html
```php
(new App\Exports\SimpleTransactionsExport())->store('transactions.xlsx');

(new App\Exports\SimpleTransactionsExport())->store('transactions.csv'); 
```


## Multi sheet export
https://docs.laravel-excel.com/3.1/exports/multiple-sheets.html
```php
(new \App\Exports\MultiSheetTransactionExport())->store('multisheet.xlsx');
```
