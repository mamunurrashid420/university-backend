# Online Admission API Guide

This guide provides comprehensive documentation for integrating with the Online Admission API endpoints for the frontend application.

## Base URL

The API base URL is: `http://localhost:8000/api` (or your production domain)

## Authentication

The admission submission endpoint (`POST /api/admissions`) is **public** and does not require authentication. However, retrieving admission data requires authentication via Laravel Sanctum.

---

## 1. Get Dropdown Data

Before submitting an admission form, you'll need to fetch the available options for semesters, departments, and programs.

### Endpoint

```
GET /api/public/dropdowns
```

### Authentication

**No authentication required** - This is a public endpoint.

### Response

```json
{
  "semesters": [
    {
      "id": 1,
      "name": "Spring",
      "year": 2024,
      "is_active": true,
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "departments": [
    {
      "id": 1,
      "name": "Computer Science",
      "code": "CS",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "programs": [
    {
      "id": 1,
      "department_id": 1,
      "name": "Bachelor of Science in Computer Science",
      "code": "BSCS",
      "major": "Computer Science",
      "degree_type": "Bachelor",
      "duration_years": 4,
      "total_credits": 120,
      "is_active": true
    }
  ]
}
```

### Notes

- **Semesters**: Only active semesters are returned, ordered by year (descending) and season (Spring, Summer, Fall)
- **Departments**: All departments are returned, ordered alphabetically
- **Programs**: All programs are returned with their associated department information
- **Important**: When submitting an admission, ensure the selected `program_id` belongs to the selected `department_id`

### Example Request (JavaScript/Fetch)

```javascript
const response = await fetch('http://localhost:8000/api/public/dropdowns');
const data = await response.json();

console.log('Available semesters:', data.semesters);
console.log('Available departments:', data.departments);
console.log('Available programs:', data.programs);
```

---

## 2. Submit Admission Form

### Endpoint

```
POST /api/admissions
```

### Authentication

**No authentication required** - This is a public endpoint.

### Request Body

The request body must be sent as `application/json`.

#### Required Fields

| Field | Type | Description | Validation |
|-------|------|-------------|------------|
| `semester_id` | integer | ID of the selected semester | Must exist in `semesters` table |
| `department_id` | integer | ID of the selected department | Must exist in `departments` table |
| `program_id` | integer | ID of the selected program | Must exist in `programs` table AND belong to the selected department |
| `full_name` | string | Applicant's full name | Max 255 characters |
| `phone_number` | string | Applicant's phone number | Max 20 characters |
| `email` | string | Applicant's email address | Valid email format, max 255 characters |
| `ssc_roll` | string | SSC roll number | Max 50 characters |
| `ssc_registration_no` | string | SSC registration number | Max 50 characters |
| `ssc_gpa` | decimal | SSC GPA | Numeric, between 0 and 5.00 (2 decimal places) |

#### Optional Fields

| Field | Type | Description | Validation |
|-------|------|-------------|------------|
| `hear_about_us` | string | How applicant heard about the institution | One of: `Website`, `Social Media`, `Friend/Relative`, `Advertisement`, `Other` |
| `father_name` | string | Father's name | Max 255 characters |
| `mother_name` | string | Mother's name | Max 255 characters |
| `assisted_by` | string | Name of person who assisted | Max 255 characters |
| `ssc_board` | string | SSC board name | Max 100 characters |
| `ssc_passing_year` | integer | SSC passing year | Integer |
| `hsc_roll` | string | HSC roll number | Max 50 characters |
| `hsc_registration_no` | string | HSC registration number | Max 50 characters |
| `hsc_gpa` | decimal | HSC GPA | Numeric, between 0 and 5.00 (2 decimal places) |
| `hsc_board` | string | HSC board name | Max 100 characters |
| `hsc_passing_year` | integer | HSC passing year | Integer |
| `honors_roll` | string | Honors roll number | Max 50 characters |
| `honors_registration_no` | string | Honors registration number | Max 50 characters |
| `honors_gpa` | decimal | Honors GPA | Numeric, between 0 and 4.00 (2 decimal places) |
| `honors_board` | string | Honors board name | Max 100 characters |
| `honors_passing_year` | integer | Honors passing year | Integer |
| `honors_institution` | string | Honors institution name | Max 255 characters |

### Example Request (Minimal - Required Fields Only)

```json
{
  "semester_id": 1,
  "department_id": 1,
  "program_id": 1,
  "full_name": "John Doe",
  "phone_number": "1234567890",
  "email": "john@example.com",
  "ssc_roll": "1234567890",
  "ssc_registration_no": "9876543210",
  "ssc_gpa": 4.5
}
```

### Example Request (Complete - All Fields)

```json
{
  "semester_id": 1,
  "department_id": 1,
  "program_id": 1,
  "full_name": "John Doe",
  "phone_number": "1234567890",
  "email": "john@example.com",
  "hear_about_us": "Website",
  "father_name": "Father Name",
  "mother_name": "Mother Name",
  "assisted_by": "Assistant Name",
  "ssc_roll": "1234567890",
  "ssc_registration_no": "9876543210",
  "ssc_gpa": 4.5,
  "ssc_board": "Dhaka",
  "ssc_passing_year": 2020,
  "hsc_roll": "1234567891",
  "hsc_registration_no": "9876543211",
  "hsc_gpa": 4.8,
  "hsc_board": "Dhaka",
  "hsc_passing_year": 2022,
  "honors_roll": "1234567892",
  "honors_registration_no": "9876543212",
  "honors_gpa": 3.5,
  "honors_board": "University of Dhaka",
  "honors_passing_year": 2024,
  "honors_institution": "University of Dhaka"
}
```

### Success Response (201 Created)

```json
{
  "message": "Admission form submitted successfully",
  "admission": {
    "id": 1,
    "semester_id": 1,
    "department_id": 1,
    "program_id": 1,
    "full_name": "John Doe",
    "phone_number": "1234567890",
    "email": "john@example.com",
    "hear_about_us": "Website",
    "father_name": "Father Name",
    "mother_name": "Mother Name",
    "assisted_by": "Assistant Name",
    "ssc_roll": "1234567890",
    "ssc_registration_no": "9876543210",
    "ssc_gpa": "4.50",
    "ssc_board": "Dhaka",
    "ssc_passing_year": 2020,
    "hsc_roll": "1234567891",
    "hsc_registration_no": "9876543211",
    "hsc_gpa": "4.80",
    "hsc_board": "Dhaka",
    "hsc_passing_year": 2022,
    "honors_roll": "1234567892",
    "honors_registration_no": "9876543212",
    "honors_gpa": "3.50",
    "honors_board": "University of Dhaka",
    "honors_passing_year": 2024,
    "honors_institution": "University of Dhaka",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z",
    "semester": {
      "id": 1,
      "name": "Spring",
      "year": 2024,
      "is_active": true
    },
    "department": {
      "id": 1,
      "name": "Computer Science",
      "code": "CS"
    },
    "program": {
      "id": 1,
      "name": "Bachelor of Science in Computer Science",
      "code": "BSCS"
    }
  }
}
```

### Error Response (422 Unprocessable Entity)

When validation fails, the API returns a 422 status code with detailed error messages:

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "semester_id": [
      "The semester id field is required."
    ],
    "email": [
      "The email field must be a valid email address."
    ],
    "ssc_gpa": [
      "SSC GPA must not be greater than 5.00."
    ],
    "program_id": [
      "The selected program does not belong to the selected department."
    ]
  }
}
```

### Example Request (JavaScript/Fetch)

```javascript
const admissionData = {
  semester_id: 1,
  department_id: 1,
  program_id: 1,
  full_name: "John Doe",
  phone_number: "1234567890",
  email: "john@example.com",
  ssc_roll: "1234567890",
  ssc_registration_no: "9876543210",
  ssc_gpa: 4.5,
  hear_about_us: "Website",
  hsc_gpa: 4.8,
  hsc_passing_year: 2022
};

try {
  const response = await fetch('http://localhost:8000/api/admissions', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify(admissionData)
  });

  const data = await response.json();

  if (response.ok) {
    console.log('Success:', data.message);
    console.log('Admission ID:', data.admission.id);
  } else {
    // Handle validation errors
    console.error('Validation errors:', data.errors);
  }
} catch (error) {
  console.error('Network error:', error);
}
```

### Example Request (Axios)

```javascript
import axios from 'axios';

const admissionData = {
  semester_id: 1,
  department_id: 1,
  program_id: 1,
  full_name: "John Doe",
  phone_number: "1234567890",
  email: "john@example.com",
  ssc_roll: "1234567890",
  ssc_registration_no: "9876543210",
  ssc_gpa: 4.5
};

try {
  const response = await axios.post(
    'http://localhost:8000/api/admissions',
    admissionData,
    {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    }
  );

  console.log('Success:', response.data.message);
  console.log('Admission ID:', response.data.admission.id);
} catch (error) {
  if (error.response) {
    // Validation errors
    console.error('Validation errors:', error.response.data.errors);
  } else {
    // Network error
    console.error('Network error:', error.message);
  }
}
```

---

## 3. Validation Rules Summary

### Critical Validation Rules

1. **Program-Department Relationship**: The `program_id` must belong to the selected `department_id`. If they don't match, validation will fail.

2. **GPA Ranges**:
   - SSC GPA: 0.00 to 5.00
   - HSC GPA: 0.00 to 5.00 (if provided)
   - Honors GPA: 0.00 to 4.00 (if provided)

3. **Email Format**: Must be a valid email address format.

4. **hear_about_us**: Must be one of the predefined values: `Website`, `Social Media`, `Friend/Relative`, `Advertisement`, `Other`.

5. **Numeric Fields**: 
   - GPA fields accept decimal values (2 decimal places)
   - Passing year fields accept integers only

### Common Validation Errors

| Error | Cause | Solution |
|-------|-------|----------|
| `The semester id field is required` | Missing `semester_id` | Include a valid semester ID |
| `The selected program does not belong to the selected department` | Program doesn't belong to department | Ensure program belongs to selected department |
| `SSC GPA must not be greater than 5.00` | GPA exceeds maximum | Ensure GPA is between 0 and 5.00 |
| `The email field must be a valid email address` | Invalid email format | Use a valid email format (e.g., `user@example.com`) |
| `The hear about us field is invalid` | Invalid value for `hear_about_us` | Use one of: Website, Social Media, Friend/Relative, Advertisement, Other |

---

## 4. Frontend Implementation Tips

### Step 1: Fetch Dropdown Data

```javascript
// Fetch dropdown options on component mount
const [semesters, setSemesters] = useState([]);
const [departments, setDepartments] = useState([]);
const [programs, setPrograms] = useState([]);

useEffect(() => {
  fetch('http://localhost:8000/api/public/dropdowns')
    .then(res => res.json())
    .then(data => {
      setSemesters(data.semesters);
      setDepartments(data.departments);
      setPrograms(data.programs);
    });
}, []);
```

### Step 2: Filter Programs by Department

```javascript
// When department changes, filter programs
const [selectedDepartment, setSelectedDepartment] = useState(null);
const [selectedProgram, setSelectedProgram] = useState(null);

const availablePrograms = programs.filter(
  program => program.department_id === selectedDepartment
);

// Reset program selection when department changes
useEffect(() => {
  setSelectedProgram(null);
}, [selectedDepartment]);
```

### Step 3: Handle Form Submission

```javascript
const handleSubmit = async (formData) => {
  try {
    const response = await fetch('http://localhost:8000/api/admissions', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(formData)
    });

    const data = await response.json();

    if (response.ok) {
      // Success - show success message
      alert('Admission submitted successfully!');
      // Reset form or redirect
    } else {
      // Handle validation errors
      if (data.errors) {
        // Display errors to user
        Object.keys(data.errors).forEach(field => {
          console.error(`${field}: ${data.errors[field][0]}`);
        });
      }
    }
  } catch (error) {
    console.error('Network error:', error);
  }
};
```

### Step 4: Display Validation Errors

```javascript
const [errors, setErrors] = useState({});

// In your error handling
if (data.errors) {
  setErrors(data.errors);
}

// In your form JSX
{errors.email && (
  <div className="error-message">{errors.email[0]}</div>
)}
```

---

## 5. Testing the API

You can test the API endpoints using tools like:

- **Postman**
- **cURL**
- **Thunder Client** (VS Code extension)
- **Browser DevTools** (for GET requests)

### Example cURL Commands

#### Get Dropdown Data
```bash
curl -X GET http://localhost:8000/api/public/dropdowns \
  -H "Accept: application/json"
```

#### Submit Admission
```bash
curl -X POST http://localhost:8000/api/admissions \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "semester_id": 1,
    "department_id": 1,
    "program_id": 1,
    "full_name": "John Doe",
    "phone_number": "1234567890",
    "email": "john@example.com",
    "ssc_roll": "1234567890",
    "ssc_registration_no": "9876543210",
    "ssc_gpa": 4.5
  }'
```

---

## 6. Additional Notes

- **CORS**: Ensure your frontend domain is configured in Laravel's CORS settings if making requests from a different origin.
- **Rate Limiting**: The API may have rate limiting enabled. Check with your backend team for specific limits.
- **Error Handling**: Always handle both network errors and validation errors in your frontend application.
- **Data Types**: 
  - GPA values are returned as strings with 2 decimal places (e.g., `"4.50"`)
  - Integer fields (like `passing_year`) should be sent as numbers, not strings
- **Date Format**: All timestamps are returned in ISO 8601 format (UTC).

---

## Support

For questions or issues, please contact the backend development team or refer to the API test files in `tests/Feature/AdmissionTest.php` for additional examples.

