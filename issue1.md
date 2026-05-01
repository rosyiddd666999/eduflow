# Issue 1: Project Initialization & Database Schema

## Overview
Set up the initial Laravel project, install the required Filament v3 panels, and establish the core database schema for EduFlow MVP.

**Design Reference**: [Lovable UI Design](https://id-preview--d47f8960-842c-4cd1-91c0-218632336ea5.lovable.app/?__lovable_token=eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoiZHpYTmw5ek5kNlpKRXlFdWJJcFl6ckRGMzdmMSIsInByb2plY3RfaWQiOiJkNDdmODk2MC04NDJjLTRjZDEtOTFjMC0yMTg2MzIzMzZlYTUiLCJhY2Nlc3NfdHlwZSI6InByb2plY3QiLCJpc3MiOiJsb3ZhYmxlLWFwaSIsInN1YiI6ImQ0N2Y4OTYwLTg0MmMtNGNkMS05MWMwLTIxODYzMjMzNmVhNSIsImF1ZCI6WyJsb3ZhYmxlLWFwcCJdLCJleHAiOjE3NzgyMzQxMjUsIm5iZiI6MTc3NzYyOTMyNSwiaWF0IjoxNzc3NjI5MzI1fQ.H1qjD801SUFJBtHvywqQKV6g9m3AQQFabhbzqDylIRI8LfKYt39SCzq3l_-V3eU8eUsXfJTsNOYRPih2lcovmZCStDb9Hgq_o9SGj_JIHlBQWuZXeiPkrxba_7J6FPMFsYpKqMMN8R-l6WI61QKfJKf-0kAtRe4Z4d7nf4yIUsLAG4-RLFqMgOslVnQxfIBHpyheZR40GenYMoiczHP7DGtwibQNk_pXtZwbVnzQthr2ClJdZJqTTZezTZ0b1nnFG7ZLA0MF4MXytekh6VdcbGxT7aWi9LY4_zyqyvla0yUnHdE4UgSvuHvYC5h-WDCk_wlHy51XaV12ZAp6uj8-F6alftGbPA_GDHrp3CAgFhnWp7_QLhEccKbjr5MJTPRghnAlLRWhdFi5cDkghxH2OVSv36qjen0gU5lrEUxl9YzNbSth3vK3O0-vIBfGJLJAInglS8A1xlyRMJU12BVm_eW6y8l81nXAardarREXMYVIFD3cPsCYJcnZCfau45bx6vq1GnLT1Wk4gkrgTSWC2ShVb3k8eZuo018qVgT72sD35o9DST-zvWq5QY0AusdtjpGiqKQB9zRqHJ7tGCT-BBta2ZWLlfwJJWnuX6HQdUoq6MliKxRK27diBJkxbgbVgXMzdu_nVQ-WPbXcrNCCnN3Zu3zxeahm0XBg91dh--U)

## Tasks

### 1. Stack Setup
- [ ] Create a new Laravel 11 project named `eduflow` (or use the current repository root).
- [ ] Require `filament/filament:"^3.2"`.
- [ ] Install Filament and configure `.env` with MySQL credentials (`eduflow` database).

### 2. Filament Panels Configuration
- [ ] Generate the **Admin** panel (`/admin`) and set `->authGuard('admin')`.
- [ ] Generate the **Teacher** panel (`/guru`) and set `->authGuard('teacher')`.
- [ ] Generate the **Student** panel (`/siswa`) and set `->authGuard('student')`.

### 3. Database Schema & Migrations
Create the following tables in this specific order:

1. **`users`** (Modify existing default migration)
   - Add `role` enum (`admin`, `teacher`, `student`).
   - Add `school_name` (string, nullable).

2. **`quizzes`**
   - `teacher_id` (Foreign Key to `users.id`)
   - `title` (string)
   - `subject` (string)
   - `description` (text)
   - `duration_minutes` (integer)

3. **`questions`**
   - `quiz_id` (Foreign Key to `quizzes.id`)
   - `question_text` (text)
   - `option_a` (string)
   - `option_b` (string)
   - `option_c` (string)
   - `option_d` (string)
   - `correct_answer` (enum: `a`, `b`, `c`, `d`)

4. **`quiz_attempts`**
   - `quiz_id` (Foreign Key to `quizzes.id`)
   - `student_id` (Foreign Key to `users.id`)
   - `score` (integer)
   - `total_questions` (integer)
   - `correct_answers` (integer)
   - `accuracy` (decimal 5,2)
   - `completed_at` (timestamp)

5. **`videos`**
   - `teacher_id` (Foreign Key to `users.id`)
   - `title` (string)
   - `description` (text)
   - `type` (enum: `youtube`, `upload`)
   - `url` (string)

### 4. Database Seeding
- [ ] Create a `DatabaseSeeder` that seeds:
  - 1 Admin
  - 2 Teachers
  - 6 Students
