# Calendar

## Created by Spencer Armon and Adam Kirsch for CSE 330

### Made to work in an EC2 instance but the instance was stopped for cost-saving purposes. Reach out to spencerarmon473@gmail.com to turn on the instance and watch how it works

#### Capabilities:
- Create/edit/tag/delete events with title, date, and time
- Filter events by tag 
- Create/delete accounts

#### Safeguards: 
- Prevents XSS attacks
- Uses HTTP cookies and passes tokens to prevent CSRF attacks
- Prevents SQL Injection attacks
