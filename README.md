# API Management System

A robust API management system built with Laravel, featuring role-based access control, endpoint management, and template-based content management.

## Project Overview

This system provides a comprehensive solution for managing APIs, endpoints, collections, and templates with a focus on security and organization. It includes features for managing HTTP methods, headers, payloads, and user permissions.

## Database Structure

### Core Tables

1. **Users**
   - Standard user authentication
   - Email verification support
   - Password reset functionality

2. **Permissions & Roles**
   - Role-based access control
   - Permission management
   - Team-based permissions support

3. **Groups**
   - Organization of endpoints and collections
   - Status tracking (active/inactive)
   - User association and ownership

4. **Collections**
   - Group-based organization
   - Status management
   - Soft delete support
   - Audit trail (created_by, updated_by, deleted_by)

5. **Endpoints**
   - HTTP method association
   - URI management
   - Collection and group relationships
   - Status tracking
   - Audit trail

6. **HTTP Methods**
   - Standard HTTP verbs (GET, POST, PUT, PATCH, DELETE, OPTIONS)

7. **Headers**
   - Endpoint-specific headers
   - Key-value pair storage
   - Status management
   - Audit trail

8. **Payloads**
   - JSON body storage
   - Endpoint association
   - Status tracking
   - Audit trail

9. **Templates**
   - Dynamic field configurations
   - Active/inactive status
   - Slug-based routing
   - Template pages management

10. **Template Pages**
    - Content management
    - Dynamic data storage
    - Publishing workflow
    - Slug-based routing

## Features

- Role-based access control
- API endpoint management
- Collection organization
- Template-based content management
- HTTP method management
- Header management
- Payload management
- Audit trail for all operations
- Soft delete support
- Status tracking for resources

## Technical Stack

- Laravel Framework
- MySQL Database
- Role and Permission Management

## Contact

**Developer:** Najmul Hasan  
**Role:** Software Engineer  
**Email:** najmulhasansobuj87@gmail.com

## License

This project is proprietary software. All rights reserved.
