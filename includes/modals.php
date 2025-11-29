<!-- =================== Admin Manage Modals =================== -->

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
    
                    <div class="mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Teacher</label>
                        <input type="text" name="teacher" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Course</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="course_id" id="editCourseId">
    
                    <div class="mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" id="editDescription" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Teacher</label>
                        <input type="text" name="teacher" id="editTeacher" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" id="editSubject" class="form-control" required>
                    </div>  
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Course</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Grade Modal -->
 <div class="modal fade" id="addGradeModal" tabindex="-1" aria-labelledby="addGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGradeModalLabel">Add New Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    
                <div class="mb-2">
                    <label class="form-label">Grade</label>
                    <input type="text" name="grade" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Comments</label>
                    <textarea name="comments" class="form-control" rows="3"></textarea>
                </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Grade</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Grade Modal -->
 <div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="course_id" id="editCourseId">
    
                    <div class="mb-2">
                        <label class="form-label">Grade</label>
                        <input type="text" name="grade" id="editGrade" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Comments</label>
                        <input type="text" name="comments" id="editComments" class="form-control" required>
                    </div> 
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Grade</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
    
                    <div class="mb-2">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Student</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="student_id" id="editStudentId">
    
                    <div class="mb-2">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" id="editUsername" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" id="editFullName" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="editGender" class="form-select">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" id="editBirthDate" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" id="editPhone" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" id="editAddress" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Student</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeacherModalLabel">Add New Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
    
                    <div class="mb-2">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Teacher</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Teacher Modal -->
<div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTeacherModalLabel">Edit Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="teacher_id" id="editTeacherId">
    
                    <div class="mb-2">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" id="editUsername" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" id="editFullName" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="editGender" class="form-select">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" id="editBirthDate" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" id="editPhone" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" id="editAddress" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Teacher</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =================== Admin Dashboard Modals =================== -->
<!-- Generate Report Modal -->
<div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="generateReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="GET" action="generate_report.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateReportModalLabel">Generate Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="reportType" class="form-label">Report Type</label>
                        <select class="form-select" id="reportType" name="report_type" required>
                            <option value="students">Students</option>
                            <option value="courses">Courses</option>
                            <option value="grades">Grades</option>
                            <option value="enrollments">Enrollments</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="startDate" class="form-label">From</label>
                        <input type="date" class="form-control" id="startDate" name="start_date" required>
                    </div>

                    <div class="mb-2">
                        <label for="endDate" class="form-label">To</label>
                        <input type="date" class="form-control" id="endDate" name="end_date" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="generate_report" class="btn btn-primary">Generate Report</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Mark Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Mark Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="mark_attendance">

                    <div class="mb-2">
                        <label class="form-label">Student ID</label>
                        <input type="number" name="student_id" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Mark Attendance</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send Announcement Modal -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="announcementModalLabel">Send Announcement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Send To</label>
                        <select class="form-select" name="audience" required>
                            <option value="students">Students</option>
                            <option value="teachers">Teachers</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="send_announcement" class="btn btn-primary">Send</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

