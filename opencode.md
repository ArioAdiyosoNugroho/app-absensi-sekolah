# OPENCODE.md

# PROJECT NAME

Smart School Attendance System

---

# PROJECT DESCRIPTION

Build a modern school attendance system using Laravel Blade View and Bootstrap 5.

The application is used for:
- School attendance
- Teacher attendance
- Student attendance
- Permission/sick requests
- GPS attendance validation
- Selfie attendance
- Attendance reports

This project MUST use:
- beginner-friendly Laravel code
- simple controller logic
- easy-to-understand structure
- clean coding style

DO NOT use:
- React
- Vue
- Inertia
- Livewire
- Complex API architecture

Use standard Laravel MVC structure only.

---

# TECH STACK

Backend:
- Laravel 13
- MySQL

Frontend:
- Laravel Blade
- tailwind css

Packages:
- maatwebsite/excel
- barryvdh/laravel-dompdf

Maps:
- LeafletJS
- OpenStreetMap

Camera:
- HTML5 Camera API

---

# USER ROLES

## Admin
Can:
- manage users
- manage classes
- manage school locations
- approve permissions
- export reports
- manage announcements
- see statistics

## Guru
Can:
- check in
- check out
- submit permission
- view attendance history

## Murid
Can:
- check in
- check out
- submit permission
- view attendance history

---

# MAIN FEATURES

## Authentication
- Login
- Logout

Use Laravel session authentication.

---

# Attendance System

Users can:
- Check in
- Check out
- Upload selfie
- Validate GPS location

Attendance rules:
- GPS required
- Camera required
- Must be inside attendance radius
- Prevent double attendance

---

# GPS VALIDATION

Admin can set attendance location using:
- map picker
- manual coordinates

Use Haversine formula to calculate distance.

Maximum attendance radius:
50 meters

If user outside radius:
attendance rejected

---

# SELFIE VERIFICATION

Users must take selfie during attendance.

Store selfie image in:
storage/app/public/selfies

---

# PERMISSION SYSTEM

Permission types:
- sick
- permission
- other

Users must:
- write reason
- upload proof image

Admin can:
- approve
- reject

---

# LATE ATTENDANCE

System automatically detects late attendance.

Example:
School start: 07:00
User check in: 07:15

Result:
status = late
late_minutes = 15

---

# DASHBOARD

## Admin Dashboard
Display:
- total attendance
- total late
- total sick
- monthly statistics
- attendance charts

## Guru/Murid Dashboard
Display:
- attendance history
- today attendance
- late count

---

# ANNOUNCEMENTS

Admin can:
- create announcement
- edit announcement
- delete announcement

Users can:
- view announcements

---

# EXPORT FEATURES

Admin can export:
- PDF
- Excel

Filters:
- daily
- weekly
- monthly
- by class

---

# DATABASE TABLES

## users
- id
- name
- email
- password
- role
- nis_nip
- gender
- phone
- avatar

## classes
- id
- name
- major

## class_user
- id
- class_id
- user_id

## school_locations
- id
- name
- address
- latitude
- longitude
- radius_meter

## attendances
- id
- user_id
- school_location_id
- attendance_date
- check_in
- check_out
- status
- late_minutes
- selfie
- latitude
- longitude
- distance_meter
- note

## permissions
- id
- user_id
- type
- reason
- attachment
- start_date
- end_date
- status
- approved_by

## announcements
- id
- title
- content
- created_by

## attendance_settings
- id
- role
- check_in_start
- late_after
- check_out_time

---

# ATTENDANCE STATUS

- present
- late
- permission
- sick
- absent

---

# PERMISSION STATUS

- pending
- approved
- rejected

---

# APPLICATION FLOW

# LOGIN FLOW

1. User login
2. Redirect by role
3. Open dashboard

---

# CHECK IN FLOW

1. User clicks check in
2. Browser requests:
   - GPS permission
   - Camera permission
3. System captures:
   - selfie
   - latitude
   - longitude
4. Backend calculates distance
5. If distance <= 50 meters:
   - attendance success
6. If distance > 50 meters:
   - attendance rejected

---

# CHECK OUT FLOW

1. User clicks check out
2. Save check out time
3. Update attendance record

---

# PERMISSION FLOW

1. User submits permission
2. Upload proof image
3. Admin reviews request
4. Admin approves/rejects

---

# MAPS FEATURE

Admin can:
- select school location from map
- input latitude longitude manually

Use:
- LeafletJS
- OpenStreetMap

---

# IMPORTANT VALIDATIONS

- Prevent double attendance
- Require GPS
- Require selfie
- Validate uploaded files
- Check attendance radius
- Protect routes by role

---

# FRONTEND PAGES

## Admin Pages
- Dashboard
- Users
- Classes
- Attendance Reports
- Permissions
- School Locations
- Announcements
- Settings

## Guru/Murid Pages
- Dashboard
- Attendance
- Permission
- Attendance History
- Profile

---

# UI STYLE

Use:
- Bootstrap 5
- Responsive dashboard
- Sidebar navigation
- Clean cards
- Mobile friendly design

---

# PROJECT STRUCTURE

app/
├── Http/
│   ├── Controllers
│   ├── Middleware
│   └── Requests
├── Models
├── Exports
├── Helpers

resources/views/
├── layouts
├── admin
├── guru
├── murid
├── auth

---

# DEVELOPMENT FLOW

1. Install Laravel
2. Setup authentication
3. Create migrations
4. Create models
5. Create relationships
6. Create middleware role
7. Create attendance CRUD
8. Create GPS validation
9. Create selfie upload
10. Create permission system
11. Create dashboard
12. Create export PDF
13. Create export Excel
14. Final testing

---

# IMPORTANT CODING STYLE

Use:
- beginner-friendly code
- readable variable names
- clean controller logic
- reusable validation
- simple MVC structure

Avoid:
- overengineering
- complex service container logic
- complicated architecture

The project must be easy to understand by beginner Laravel developers.

---

# IMPORTANT

Provide:
- Full migration code
- Full model code
- Full controller code
- Full middleware
- Full routes/web.php
- Full Blade views
- Full Bootstrap UI
- Full GPS validation logic
- Full attendance logic
- Full export implementation
- Full comments in code
