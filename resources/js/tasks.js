// $(document).ready(function () {
//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//     });

//     // Initialize SweetAlert
//     Swal.fire({
//         title: "Welcome!",
//         text: "You have successfully loaded the page.",
//         icon: "success",
//         confirmButtonText: "Ok",
//     });

//     // Create Task
//     $("#createTaskForm").on("submit", function (e) {
//         e.preventDefault();
//         let formData = $(this).serialize();

//         $.ajax({
//             type: "POST",
//             url: "/tasks",
//             data: formData,
//             success: function (response) {
//                 let newTask = response.task;
//                 let taskHtml = createTaskHtml(newTask);
//                 $("#tasksList").prepend(taskHtml);

//                 $("#createTaskForm")[0].reset();
//                 $("#createTaskModal").modal("hide");

//                 Swal.fire({
//                     icon: "success",
//                     title: "Success",
//                     text: "Task created successfully",
//                 });
//             },
//             error: function (xhr) {
//                 let errors = xhr.responseJSON.errors;
//                 displayErrors(errors);
//             },
//         });
//     });

//     $(document).on("submit", ".updateTaskForm", function (e) {
//         e.preventDefault();
//         let formData = $(this).serialize();
//         let taskId = $(this).data("task-id");

//         $.ajax({
//             type: "PUT",
//             url: "/tasks/" + taskId,
//             data: formData,
//             success: function (response) {
//                 let updatedTask = response.task;
//                 $(`#task-${taskId}`).replaceWith(createTaskHtml(updatedTask));

//                 $("#editTaskModal").modal("hide");

//                 Swal.fire({
//                     icon: "success",
//                     title: "Success",
//                     text: "Task updated successfully",
//                 });
//             },
//             error: function (xhr) {
//                 let errors = xhr.responseJSON.errors;
//                 displayErrors(errors);
//             },
//         });
//     });

//     // Delete Task
//     $(document).on("click", ".deleteTask", function (e) {
//         e.preventDefault();
//         let taskId = $(this).data("task-id");

//         Swal.fire({
//             title: "Are you sure?",
//             text: "You won't be able to revert this!",
//             icon: "warning",
//             showCancelButton: true,
//             confirmButtonColor: "#3085d6",
//             cancelButtonColor: "#d33",
//             confirmButtonText: "Yes, delete it!",
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 $.ajax({
//                     type: "DELETE",
//                     url: "/tasks/" + taskId,
//                     success: function (response) {
//                         // Remove task from the list
//                         $(`#task-${taskId}`).fadeOut(300, function () {
//                             $(this).remove();
//                         });

//                         Swal.fire(
//                             "Deleted!",
//                             "Task has been deleted.",
//                             "success"
//                         );
//                     },
//                     error: function (xhr) {
//                         Swal.fire("Error!", "Something went wrong.", "error");
//                     },
//                 });
//             }
//         });
//     });

//     // Mark as Complete
//     $(document).on("click", ".markComplete", function (e) {
//         e.preventDefault();
//         let taskId = $(this).data("task-id");

//         $.ajax({
//             type: "POST",
//             url: `/tasks/${taskId}/complete`,
//             success: function (response) {
//                 $(`#task-${taskId}`)
//                     .find(".status")
//                     .html('<span class="badge bg-success">Completed</span>');
//                 Swal.fire({
//                     icon: "success",
//                     title: "Success",
//                     text: "Task marked as completed",
//                 });
//             },
//         });
//     });

//     // Helper function to create task HTML
//     function createTaskHtml(task) {
//         return `
//             <div class="card mb-3" id="task-${task.id}">
//                 <div class="card-body">
//                     <h5 class="card-title">${task.title}</h5>
//                     <p class="card-text">${task.description}</p>
//                     <div class="task-details">
//                         <span class="badge bg-${getPriorityClass(
//                             task.priority
//                         )}">${task.priority}</span>
//                         <span class="ms-2">Due: ${task.due_date}</span>
//                     </div>
//                     <div class="mt-3">
//                         <button class="btn btn-sm btn-primary editTask" data-task-id="${
//                             task.id
//                         }">Edit</button>
//                         <button class="btn btn-sm btn-danger deleteTask" data-task-id="${
//                             task.id
//                         }">Delete</button>
//                         <button class="btn btn-sm btn-success markComplete" data-task-id="${
//                             task.id
//                         }">Mark Complete</button>
//                     </div>
//                 </div>
//             </div>
//         `;
//     }

//     // Helper function for priority classes
//     function getPriorityClass(priority) {
//         switch (priority) {
//             case "high":
//                 return "danger";
//             case "medium":
//                 return "warning";
//             case "low":
//                 return "info";
//             default:
//                 return "secondary";
//         }
//     }

//     // Helper function to display errors
//     function displayErrors(errors) {
//         let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
//         $.each(errors, function (key, value) {
//             errorHtml += `<li>${value}</li>`;
//         });
//         errorHtml += "</ul></div>";
//         $("#errorContainer").html(errorHtml);
//     }
// });

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Create Task
    $("#createTaskForm").on("submit", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/tasks",
            data: formData,
            success: function (response) {
                let newTask = response.task;
                let taskHtml = createTaskHtml(newTask);
                $("#tasksList").prepend(taskHtml);

                $("#createTaskForm")[0].reset();
                $("#createTaskModal").modal("hide");

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Task created successfully",
                });
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                displayErrors(errors);
            },
        });
    });

    // Update Task
    $(document).on("submit", ".updateTaskForm", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let taskId = $(this).data("task-id");

        $.ajax({
            type: "PUT",
            url: `/tasks/${taskId}`,
            data: formData,
            success: function (response) {
                let updatedTask = response.task;
                $(`#task-${taskId}`).replaceWith(createTaskHtml(updatedTask));

                $("#editTaskModal").modal("hide");

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Task updated successfully",
                });
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                displayErrors(errors);
            },
        });
    });

    // Delete Task
    $(document).on("click", ".deleteTask", function (e) {
        e.preventDefault();
        let taskId = $(this).data("task-id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: `/tasks/${taskId}`,
                    success: function (response) {
                        $(`#task-${taskId}`).fadeOut(300, function () {
                            $(this).remove();
                        });

                        Swal.fire(
                            "Deleted!",
                            "Task has been deleted.",
                            "success"
                        );
                    },
                    error: function (xhr) {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    },
                });
            }
        });
    });

    // Mark as Complete
    $(document).on("click", ".markComplete", function (e) {
        e.preventDefault();
        let taskId = $(this).data("task-id");

        $.ajax({
            type: "POST",
            url: `/tasks/${taskId}/complete`,
            success: function (response) {
                $(`#task-${taskId}`)
                    .find(".status")
                    .html('<span class="badge bg-success">Completed</span>');
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Task marked as completed",
                });
            },
        });
    });

    // Helper function to create task HTML
    function createTaskHtml(task) {
        return `
            <div class="card mb-3" id="task-${task.id}">
                <div class="card-body">
                    <h5 class="card-title">${task.title}</h5>
                    <p class="card-text">${task.description}</p>
                    <div class="task-details">
                        <span class="badge bg-${getPriorityClass(
                            task.priority
                        )}">${task.priority}</span>
                        <span class="ms-2">Due: ${task.due_date}</span>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-primary editTask" data-task-id="${
                            task.id
                        }">Edit</button>
                        <button class="btn btn-sm btn-danger deleteTask" data-task-id="${
                            task.id
                        }">Delete</button>
                        <button class="btn btn-sm btn-success markComplete" data-task-id="${
                            task.id
                        }">Mark Complete</button>
                    </div>
                </div>
            </div>
        `;
    }

    // Helper function for priority classes
    function getPriorityClass(priority) {
        switch (priority) {
            case "high":
                return "danger";
            case "medium":
                return "warning";
            case "low":
                return "info";
            default:
                return "secondary";
        }
    }

    // Helper function to display errors
    function displayErrors(errors) {
        let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
        $.each(errors, function (key, value) {
            errorHtml += `<li>${value}</li>`;
        });
        errorHtml += "</ul></div>";
        $("#errorContainer").html(errorHtml);
    }
});
