# Financial Information System Database

This project implements a Financial Information System using Laravel's Eloquent ORM to manage financial transactions and reporting.

## Database Schema

### 1. Users Table
- Extends Laravel's default users table
- Added `role` column: enum('admin', 'bendahara', 'auditor')
- Roles determine user permissions in the system

### 2. Categories Table
- `id`: Primary key
- `name`: Category name (e.g., "Pendapatan Usaha", "Biaya Operasional")
- `type`: enum('income', 'expense') - to distinguish between income and expense categories
- `description`: Optional description of the category

### 3. Transactions Table
- `id`: Primary key
- `user_id`: Foreign key linking to users table
- `category_id`: Foreign key linking to categories table
- `amount`: Decimal value of the transaction amount
- `description`: Description of the transaction
- `type`: enum('income', 'expense')
- `date`: Date of the transaction
- `receipt_id`: Optional foreign key linking to receipts table

### 4. Receipts Table
- `id`: Primary key
- `receipt_number`: Unique receipt number
- `title`: Title of the receipt
- `description`: Description of the receipt
- `amount`: Amount on the receipt
- `issued_date`: Date when the receipt was issued
- `issued_by`: Name of the person who issued the receipt
- `recipient_name`: Name of the recipient
- `recipient_address`: Address of the recipient

### 5. Cash Balances Table
- `id`: Primary key
- `user_id`: Foreign key linking to users table
- `balance`: Current cash balance
- `date`: Date of the balance record
- `description`: Description of the balance entry

### 6. Reports Table
- `id`: Primary key
- `user_id`: Foreign key linking to users table
- `title`: Title of the report
- `type`: enum('monthly', 'quarterly', 'annual') - type of report
- `period_start`: Start date of the reporting period
- `period_end`: End date of the reporting period
- `total_income`: Total income during the period
- `total_expenses`: Total expenses during the period
- `net_income`: Net income (total income - total expenses)
- `content`: Detailed content of the report
- `file_path`: Optional path to the report file

## Features Implemented

1. **Financial Transaction Recording**: 
   - Income and expense recording with categorization
   - Date tracking and descriptions
   - User attribution

2. **Monthly Financial Reports**:
   - Automated calculation of income, expenses, and net income
   - Time period specification
   - Detailed content and file attachment options

3. **Digital Receipts**:
   - Unique receipt numbers
   - Issuer and recipient information
   - Amount tracking

4. **Cash Balance Monitoring**:
   - Real-time cash balance tracking
   - Historical balance records
   - Date-specific balance tracking

5. **Role-based Access Control**:
   - Admin Keuangan: Full access to all features
   - Bendahara: Transaction recording and basic reporting
   - Auditor: Read-only access for auditing purposes

## Eloquent Models

Each table has a corresponding Eloquent model with appropriate relationships:

- **User**: Has many transactions, cash balances, and reports
- **Category**: Has many transactions
- **Transaction**: Belongs to user, category, and receipt
- **Receipt**: Has many transactions
- **CashBalance**: Belongs to user
- **Report**: Belongs to user

## Usage

After running migrations, you can interact with the financial system using Eloquent ORM:

```php
// Record an income transaction
$transaction = Transaction::create([
    'user_id' => auth()->id(),
    'category_id' => $incomeCategory->id,
    'amount' => 5000000,
    'description' => 'Sales revenue',
    'type' => 'income',
    'date' => now()
]);

// Calculate total income for the current month
$totalIncome = Transaction::where('type', 'income')
    ->whereMonth('date', now()->month)
    ->sum('amount');

// Generate monthly report
$report = Report::create([
    'user_id' => auth()->id(),
    'title' => 'Monthly Report ' . now()->format('F Y'),
    'type' => 'monthly',
    'period_start' => now()->startOfMonth(),
    'period_end' => now()->endOfMonth(),
    'total_income' => $totalIncome,
    // ... other fields
]);
```

This structure supports all the requirements for the Financial Information System while maintaining good database design principles and leveraging Laravel's Eloquent ORM capabilities.