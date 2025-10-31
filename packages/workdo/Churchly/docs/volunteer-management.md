# Volunteer Management

New volunteer tooling lives inside the Churchly module and provides:

- **Profiles** stored in `church_volunteers` with optional links to existing members.
- **Skills library** for tagging volunteers and tracking proficiency.
- **Training records, availability slots, and service assignments** with inline management tools.

## Migrations

Run the new migration to provision the tables:

```bash
php artisan migrate --path=packages/workdo/Churchly/src/Database/Migrations/2025_11_01_000001_create_church_volunteer_management_tables.php
```

## Key Routes

- `churchly/volunteers` – CRUD for volunteer profiles.
- `churchly/volunteer-skills` – Manage reusable skill tags.
- Nested routes under `churchly/volunteers/{volunteer}` handle trainings, availability, and assignments.

## Permissions

- `church_volunteer manage` – access listings, view profiles, manage assignments/trainings/availability, and maintain the skills library.
- `church_volunteer create` – create new volunteer profiles and add skills inline during creation.

## Manual Test Checklist

1. **Volunteer creation** – Create a volunteer, assign departments and skills, verify status badges on the index page.
2. **Training & availability** – Add records on the detail page, edit them, and confirm collapse forms save correctly.
3. **Assignments** – Schedule the volunteer against an event and a custom service role; ensure status updates persist.
4. **Skills library** – Add a new skill, toggle activation, and ensure it appears in the volunteer form.
5. **Permissions** – Confirm users without `church_volunteer manage` cannot access the new routes.

## Notes

- Assignment forms automatically hide free-text labels when an event/session is selected; controllers backfill the label from the linked record when omitted.
- Pivot tables enforce uniqueness to prevent duplicate skill or department assignments.
