
## Simple export

```php
(new App\Exports\SimpleTransactionsExport())->store('transactions.xlsx');
```


## Multi sheet export

```php
(new \App\Exports\MultiSheetTransactionExport())->store('multisheet.xlsx');
```
