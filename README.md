# Calendar

## Created by Spencer Armon and Adam Kirsch for CSE 330

### http://tinyurl.com/armoncalendar
#### Capabilities:
- Create/edit/tag/delete events with title, date, and time
- Filter events by tag 
- Create/delete accounts

#### Safeguards: 
- Prevents XSS attacks
- Uses HTTP cookies and passes tokens to prevent CSRF attacks
- Prevents SQL Injection attacks
