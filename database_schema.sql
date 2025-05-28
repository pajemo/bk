-- Database schema for bank website using MySQL

CREATE DATABASE IF NOT EXISTS bankbd;
USE bankbd;

-- Users table
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    IsEmailVerified TINYINT(1) DEFAULT 0,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Email verification tokens
CREATE TABLE EmailVerifications (
    VerificationID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    VerificationCode VARCHAR(100) NOT NULL,
    Expiry DATETIME NOT NULL,
    IsUsed TINYINT(1) DEFAULT 0,
    FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE CASCADE
);

-- Login codes for 2FA
CREATE TABLE LoginCodes (
    LoginCodeID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    Code VARCHAR(10) NOT NULL,
    Expiry DATETIME NOT NULL,
    IsUsed TINYINT(1) DEFAULT 0,
    FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE CASCADE
);

-- Accounts table
CREATE TABLE Accounts (
    AccountID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    Balance DECIMAL(18,2) DEFAULT 0,
    AccountNumber VARCHAR(50) DEFAULT NULL,
    BankName VARCHAR(100) DEFAULT NULL,
    AccountName VARCHAR(255) DEFAULT NULL,
    RoutingNumber VARCHAR(50) DEFAULT NULL,
    SwiftBIC VARCHAR(50) DEFAULT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE CASCADE
);

-- Transactions table
CREATE TABLE Transactions (
    TransactionID INT AUTO_INCREMENT PRIMARY KEY,
    AccountID INT,
    TransactionType VARCHAR(50) NOT NULL, -- Deposit or Withdrawal
    Amount DECIMAL(18,2) NOT NULL,
    TransactionDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AccountID) REFERENCES Accounts(AccountID) ON DELETE CASCADE
);

-- ExternalTransfers table to log transfers to external banks/accounts
CREATE TABLE ExternalTransfers (
    TransferID INT AUTO_INCREMENT PRIMARY KEY,
    SenderAccountID INT NOT NULL,
    RecipientBankAccount VARCHAR(50) NOT NULL,
    RecipientBankName VARCHAR(100) NOT NULL,
    RecipientAccountName VARCHAR(255) NOT NULL,
    RoutingNumber VARCHAR(50),
    SwiftBIC VARCHAR(50),
    Amount DECIMAL(18,2) NOT NULL,
    TransferDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SenderAccountID) REFERENCES Accounts(AccountID) ON DELETE CASCADE
);
