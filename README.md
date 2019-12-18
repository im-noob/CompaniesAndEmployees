# CompaniesAndEmployees

1. Basic Laravel Auth: ability to log in as an administrator

2. Use database seeds to create the first user with email admin@admin.com and password “password”

3. CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies and Employees. (Not necessary to complete CRUD on both menus anyone can be allowed )

4. Companies DB table consists of these fields: Name (required), email, logo (minimum 100×100), website

5. Employees DB table consists of these fields: First name (required), last name (required), Company (foreign key to Companies), email, phone

6. Use database migrations to create those schemas above

7. Store companies logos in storage/app/public folder and make them accessible from public

8. Use basic Laravel resource controllers with default methods – index, create, store, etc.

9. Use Laravel’s validation function, using Request classes

10. Use Laravel’s pagination for showing Companies/Employees list, 10 entries per page

11. Use Laravel make: auth as default Bootstrap-based design theme, but remove the ability to register

