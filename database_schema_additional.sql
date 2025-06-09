-- Additional SQL to create Transactions and ExternalTransfers tables and other necessary schema updates

CREATE TABLE IF NOT EXISTS Transactions (
    TransactionID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    AccountID BIGINT UNSIGNED NOT NULL,
    TransactionType VARCHAR(50) NOT NULL,
    Amount DECIMAL(15,2) NOT NULL,
    TransactionDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AccountID) REFERENCES Accounts(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ExternalTransfers (
    ExternalTransferID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    SenderAccountID BIGINT UNSIGNED NOT NULL,
    RecipientBankAccount VARCHAR(255) NOT NULL,
    RecipientBankName VARCHAR(255) NOT NULL,
    RecipientAccountName VARCHAR(255) NOT NULL,
    RoutingNumber VARCHAR(255),
    SwiftBIC VARCHAR(255),
    Amount DECIMAL(15,2) NOT NULL,
    TransferDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SenderAccountID) REFERENCES Accounts(id) ON DELETE CASCADE
);

-- Additional indexes or constraints can be added here as needed
