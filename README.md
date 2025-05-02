# Commission Fee Calculator

A PHP application that calculates transaction commissions based on BIN (Bank Identification Number) and real-time currency exchange rates.

---

## 🚀 Features

- Retrieves country information from the **BinList API**
- Converts transaction amounts to EUR using **Exchange Rates API**
- Applies configurable commission rates for **EU vs. non-EU** transactions
- Rounds up commission to the **nearest cent**
- Clean, testable, and SOLID-based architecture

---

## 🧱 Architecture

The application is structured around service classes:

- `TransactionReader`: Reads transactions from a file
- `BinListProvider`: Retrieves country code using BIN
- `RatesProvider`: Gets exchange rate for a currency to EUR
- `EuCountryChecker`: Checks if a country is part of the EU
- `CommissionCalculator`: Calculates and rounds commission fees

---

## 📦 Requirements

- PHP 8.0+
- Composer
- Internet connection (for live API access)

---

## ⚙️ Setup

1. Clone the repository:

   git clone https://github.com/patco444/commission-calculator.git
   cd commission-calculator

2. Install dependencies:
    composer install

3. Configure API keys and settings in config/config.php:

    'rates' => [
        'base_url' => 'https://api.apilayer.com/exchangerates_data/latest',
        'api_key' => 'YOUR_API_KEY'
    ],

4. Prepare your input file:

Place it in input/input.txt

Each line should be a JSON object:
{"bin":"45717360","amount":"100.00","currency":"EUR"}

## Running the App
php app.php
    -> The script will print one commission result per line.

## Running Unit Tests
This project uses PHPUnit for unit testing. Use the command:
    php vendor/bin/phpunit