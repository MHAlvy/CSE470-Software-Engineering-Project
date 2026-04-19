# CrowdAid - Community Donation Platform (CSE470 Project)

A full-stack Laravel application designed to connect donors, receivers, and volunteer drivers to facilitate community mutual aid. 

## Features
* **Role-Based Authentication:** Distinct dashboards for Donors, Receivers and Volunteers.
* **Donation Bidding Engine:** Receivers can submit justification notes to claim items and Donors can approve or reject requests.
* **Privacy-Preserving Logistics:** Contact information is locked until a Donor explicitly approves a claim request.
* **Volunteer Routing System:** Volunteers can view a logistics board, claim delivery routes and update real-time transit statuses (Pending, Picked Up, Delivered).
* **Community Trust System:** 5-star rating engine calculating overall user reliability based on completed transactions.

## Tech Stack
* **Backend:** Laravel (PHP)
* **Frontend:** Blade Templating, Tailwind CSS
* **Database:** MySQL
* **Authentication:** Laravel Breeze
