# SIAF Autoparts - Visitor Tracking System

This system automatically tracks website visitors without requiring any login or user registration.

## Features

- **Automatic Tracking**: Every page visit is recorded automatically
- **Session-Based Counting**: Prevents counting the same user multiple times in a session
- **Daily Statistics**: Tracks visitors today, this month, and total
- **IP Address Tracking**: Also tracks unique IP addresses
- **Admin Dashboard**: View detailed statistics in the admin panel
- **No User Interaction Required**: Works transparently for all visitors

## Setup Instructions

1. **Create the Database Table**:
   - Run `create_visitors_table.php` in your browser: `http://localhost/siaf-autoparts/create_visitors_table.php`
   - Or manually execute the SQL in `create_visitors_table.sql` in phpMyAdmin

2. **The system is already integrated** into your website:
   - Visitor tracking runs automatically on every page load
   - Statistics are available in the admin panel under "Visitor Stats"

## How It Works

### Tracking Logic
- Each page visit creates a record in the `visitors` table
- Uses PHP sessions to identify unique visitors
- Same session visiting multiple pages counts as one visitor per day
- Tracks IP address, user agent, page URL, and timestamp

### Database Table Structure
```sql
CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    session_id VARCHAR(255),
    page_url VARCHAR(500),
    visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ip_date (ip_address, visit_date),
    INDEX idx_session (session_id)
) ENGINE=InnoDB;
```

### Available Statistics
- **Visitors Today**: Unique sessions that visited today
- **This Month**: Unique sessions that visited this month
- **Total Visitors**: All unique sessions ever
- **Unique IPs Today**: Unique IP addresses that visited today

## Files Modified/Created

### Modified Files:
- `setup.php` - Added visitors table creation
- `includes/functions.php` - Added tracking and stats functions
- `includes/header.php` - Added automatic tracking call
- `admin/header.php` - Added menu item for visitor stats

### New Files:
- `admin/visitor_stats.php` - Admin dashboard for viewing statistics
- `create_visitors_table.php` - Script to create the database table
- `visitor_tracking_demo.php` - Demo page showing visitor stats
- `create_visitors_table.sql` - SQL file for manual table creation

## Usage

1. **For Visitors**: Nothing changes - tracking happens automatically
2. **For Admins**: Go to Admin Panel → Visitor Stats to view statistics
3. **For Developers**: Use `getVisitorStats()` function to get stats programmatically

## Example Usage in Code

```php
require_once 'includes/functions.php';

// Get all visitor statistics
$stats = getVisitorStats();
echo "Today: " . $stats['today'];
echo "This Month: " . $stats['month'];
echo "Total: " . $stats['total'];
echo "Unique IPs Today: " . $stats['unique_today'];
```

## Security Notes

- IP addresses are stored for statistical purposes only
- No personal information is collected
- Session IDs are used for counting, not tracking individuals
- Data is stored locally in your database only

## Troubleshooting

1. **Table not created**: Run `create_visitors_table.php` manually
2. **Stats not updating**: Check that `trackVisitor()` is called in header.php
3. **Permission errors**: Ensure database user has CREATE TABLE permissions

## Demo

Visit `visitor_tracking_demo.php` to see the visitor tracking in action and view current statistics.

---

# Contact Messages System

In addition to visitor tracking, the system also includes contact form message management.

## Contact Form Features

- **Message Storage**: All contact form submissions are saved to database
- **Admin Management**: View, mark as read/replied in admin panel
- **Status Tracking**: Track message status (unread, read, replied)
- **Filtering**: Filter messages by status
- **Real-time Updates**: Messages appear immediately after form submission

## Contact Form Setup

1. **Create the Database Table**:
   - Run `create_contact_messages_table.php` in your browser: `http://localhost/siaf-autoparts/create_contact_messages_table.php`

2. **Contact form is already integrated** into `contact.php`:
   - Messages are automatically saved when users submit the form
   - Admin can view messages under "Contact Messages" in admin panel

## Contact Database Table Structure

```sql
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    product VARCHAR(200),
    message TEXT NOT NULL,
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
```

## Contact Form Files

### Modified Files:
- `contact.php` - Added database saving functionality
- `setup.php` - Added contact_messages table creation
- `admin/header.php` - Added menu item for contact messages

### New Files:
- `admin/contact_messages.php` - Admin interface for managing messages
- `create_contact_messages_table.php` - Script to create the database table

## Contact Form Usage

1. **For Users**: Fill out the contact form on the website
2. **For Admins**: Go to Admin Panel → Contact Messages to view/manage messages
3. **Message Status**: Click action buttons to mark messages as read or replied