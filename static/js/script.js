$(document).ready(function() {
    // Search for files when the user submits the search form
    $("#search-form").submit(function(event) {
        event.preventDefault();

        var query = $("#search-input").val();

        if (query.length > 0) {
            $.ajax({
                url: "search.php",
                type: "POST",
                data: {query: query},
                dataType: "json",
                success: function(data) {
                    $("#search-results").empty();

                    if (data.length > 0) {
                        $.each(data, function(index, file) {
                            var html = "<tr>";
                            html += "<td>" + file.filename + "</td>";
                            html += "<td>" + file.size + "</td>";
                            html += "<td>" + file.date_modified + "</td>";
                            html += "<td>" + file.host + "</td>";
                            html += "<td><a href=\"preview.php?filename=" + encodeURIComponent(file.filename) + "&host=" + encodeURIComponent(file.host) + "\" class=\"btn btn-primary\">Preview</a></td>";
                            html += "<td><button class=\"btn btn-primary\" onclick=\"add_task('" + encodeURIComponent(file.filename) + "', '" + encodeURIComponent(file.host) + "')\">Add to Tasks</button></td>";
                            html += "</tr>";

                            $("#search-results").append(html);
                        });
                    } else {
                        $("#search-results").append("<tr><td colspan=\"6\">No results found</td></tr>");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error: " + textStatus + " - " + errorThrown);
                }
            });
        }
    });
});

// Add a file to the list of tasks
function add_task(filename, host) {
    $.ajax({
        url: "tasks.php",
        type: "POST",
        data: {filename: filename, host: host},
        dataType: "json",
        success: function(data) {
            if (data.success) {
                alert("File added to tasks");
            } else {
                alert("Error adding file to tasks: " + data.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Error: " + textStatus + " - " + errorThrown);
        }
    });
}
