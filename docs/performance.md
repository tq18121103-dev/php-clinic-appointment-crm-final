# Performance Analysis

## Patient List

### Query

```sql
SELECT *
FROM patients
ORDER BY id DESC;
```

### EXPLAIN

- Access type: index
- Index used: PRIMARY
- Extra: Backward index scan

### Result

The query uses the PRIMARY KEY index to retrieve data in descending order efficiently.

---

## Appointment List

### Query

```sql
SELECT appointments.*, patients.full_name AS patient_name
FROM appointments
LEFT JOIN patients
ON appointments.patient_id = patients.id
WHERE appointments.appointment_code LIKE '%AP%'
ORDER BY appointments.id DESC;
```

### EXPLAIN

Appointments table

- type: index
- key: PRIMARY
- Extra: Using where; Backward index scan

Patients table

- type: eq_ref
- key: PRIMARY

### Result

The query joins the `appointments` and `patients` tables using the PRIMARY KEY. MySQL performs an efficient `eq_ref` join and uses the primary index for sorting.