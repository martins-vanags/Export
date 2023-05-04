
## Simple export
https://docs.laravel-excel.com/3.1/exports/export-formats.html
Changing the export format is as simple as changing the file extension.
```php
(new App\Exports\SimpleTransactionsExport())->store('transactions.xlsx');

(new App\Exports\SimpleTransactionsExport())->store('transactions.csv'); 
```


## Multi sheet export
https://docs.laravel-excel.com/3.1/exports/multiple-sheets.html
```php
(new \App\Exports\MultiSheetTransactionExport())->store('multisheet.xlsx');
```


## Simple export with trace
```php
(new \App\Exports\TransactionsByMonth())->store('public/transactionsByMonth.xlsx');
```
The finished export trace will be saved in the database.
```json
[
  {
    "id": 1,
    "type": "TransactionsByMonth",
    "file_path": "public/transactionsByMonth.xlsx",
    "status": "completed",
    "query_count": 888,
    "total_rows": 12,
    "processed_rows": 12,
    "content": "{\"query\":\"select SUM(amount) as total, strftime(\\"%m\\", created_at) as month from \\"transactions\\" group by strftime(\\"%m\\", created_at)\",\"bindings\":[]}",
    "created_at": "2023-05-04 14:51:29",
    "updated_at": "2023-05-04 14:51:29"
  }
]
```
