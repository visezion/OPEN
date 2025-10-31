## People & Membership Enhancements

This release extends the Churchly people module with tooling for pastoral care, household management, smart tags, and communication history.

### Highlights

- **Households** – Group members under shared households with a primary contact and shared contact information. Members can be attached from the member profile or from `Households` in the admin menu.
- **Pastoral Notes** – Secure, visibility-scoped notes stored in `church_member_notes`. Notes can be flagged for attention and are visible on the member “Pastoral Care” tab.
- **Follow-up Workflows** – Track visitor or pastoral follow-ups via `church_member_followups`. Assign team members, set due dates, and mark progress directly from the member profile.
- **Communication Log** – Log calls, emails, visits, and other touchpoints. Records live in `church_member_communications` and appear on the member timeline.
- **Giving Snapshot** – Contributions recorded in `church_member_contributions` feed the giving snapshot and smart tag rules.
- **Smart Tags** – Rules-based segments stored in `church_smart_tags`. Tags can evaluate attendance streaks, giving gaps, departments, and more. Matching members are persisted in `church_smart_tag_members`.

### Running the migrations

```bash
php artisan migrate --path=packages/workdo/Churchly/src/Database/Migrations/2025_11_02_000002_enhance_member_management.php
```

### Managing the features

- **Households:** Navigate to `Church › Households` or attach from the member profile under *Pastoral Care*.
- **Notes & Follow-ups:** Use the *Pastoral Care* tab on an individual member to create notes, assign follow-ups, or log communications.
- **Smart Tags:** Go to `Church › Smart Tags` to define JSON rules, toggle active status, and run matching. Smart tags also surface on each member profile.

### Permissions

The seeder adds the following permissions (automatically assigned to the company role):

- `church_household manage`
- `church_member_note manage`
- `church_member_followup manage`
- `church_member_communication manage`
- `church_smart_tag manage`

### Smart tag definition examples

```json
[
  {
    "type": "attendance_count",
    "operator": ">=",
    "value": 3,
    "days": 30
  },
  {
    "type": "giving_gap_days",
    "operator": ">=",
    "value": 60
  },
  {
    "type": "in_department",
    "department_ids": [5, 9]
  }
]
```

Run `php artisan db:seed --class="Workdo\\Churchly\\Database\\Seeders\\PermissionTableSeeder"` after deployment to refresh permission assignments.
