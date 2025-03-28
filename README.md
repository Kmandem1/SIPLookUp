# SIPLookUp

## Overview
SIPLookUp is a web-based tool designed to help software engineers, managers, product owners, designers, and educated end-users locate *Software Intensive Products (SIPs)*. The system extracts and summarizes the hardware and software components of these products, making it easier for users to analyze and compare different SIPs.

The platform categorizes products into different domains such as *Appliances, Cars, Wearables, Apparel, and Home & Office Products*, allowing users to search and filter results efficiently.

---

## Tech Stack

### *Frontend:*
- *HTML, CSS, JavaScript* – For structuring and interactivity
- *Materialize CSS* – For responsive UI and layout

### *Backend:*
- *PHP (API-based architecture)* – For handling requests and processing data
- *SQL (MySQL Database)* – For storing product information and summaries

### *Development & Version Control:*
- *Git & GitHub* – For version control, collaboration, and tracking progress
- *VS Code* – As the primary IDE for writing and debugging code

### *Hosting:*
- *GoDaddy* – To deploy the web application

---

## Features
- *Database Storage* – Store and manage SIP details, including hardware/software components.
- *Product Summary Generation* – Extract and display summarized details for each product.
- *Category Support* – Enable product classification into Appliances, Cars, Wearables, Apparel, and Home & Office Products.

---

## Step-by-Step Development Process

### *Phase 1: Planning & Requirements Gathering*
1. Define project objectives:
   - Create a tool to find Software Intensive Products (SIPs) and retrieve summaries of their hardware and software components.
2. Identify core features:
   - Search functionality, category-based product filtering, and summary extraction.
3. *Setup Git Repository:*
   - Create a GitHub repository for version control.
   - Initialize the repository with git init and push the initial commit.

### *Phase 2: Backend Development*
#### *Database Design*
1. Define the SIP table with the following columns:
   - ProductID, Name, Category, HardwareDetails, SoftwareDetails, SourceURL, Summary
2. Establish SQL database connection using PHP.

#### *Build PHP APIs*
- *GET API:* Fetch SIP details based on category and keywords.
- *POST API:* Store new SIP entries into the database.
- *Summarization API:* Process hardware/software details into a short summary.

### *Phase 3: Frontend Development*
1. *Setup Project Structure in VS Code.*
2. *Create UI with Materialize CSS:*
   - Navigation bar & search bar for product lookup.
   - Table/List View to display results.
   - Category selection dropdown for filtering.
3. *Connect Frontend to Backend using Fetch API & AJAX.*

### *Phase 4: Testing & Deployment*
- *Unit Testing* – Test API responses and data retrieval.
- *Frontend Testing* – Check UI responsiveness across devices.
- *Git Push & Deploy on GoDaddy:*
  - Commit and push final version to GitHub.
  - Deploy on GoDaddy and test live site performance