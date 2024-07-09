// $(document).ready(function () {
//     $('#allAnalyzeBtn').click(function () {
//         var reviewIds = [];
//         $('table tr').each(function () {
//             var id = $(this).find('td:first').text();
//             if (id !== 'ID') {
//                 reviewIds.push(id);
//             }
//         });

        
//         $.ajax({
//             url: 'processAllAnalyze.php',
//             type: 'POST',
//             data: { reviewIds: reviewIds },
//             success: function (response) {   
//                 window.location.href = 'sentiment.php';
//             },
//             error: function (xhr, status, error) {
//                 alert('Error: ' + error);
//             }
//         });
//     });
// });

$(document).ready(function () {
    $('#allAnalyzeBtn').click(function () {
        var reviewIds = [];
        // Loop through each table row except the header row
        $('table tr').each(function () {
            var id = $(this).find('td:first').text().trim(); // Get the text content of the first column
            if (id !== 'ID' && id !== '') { // Ensure it's not the header row and ID is not empty
                reviewIds.push(id); // Push the ID into the array
            }
        });

        // Check if there are review IDs to process
        if (reviewIds.length > 0) {
            $.ajax({
                url: 'processAllAnalyze.php',
                type: 'POST',
                data: { reviewIds: reviewIds },
                success: function (response) {
                    // Redirect to sentiment.php after processing
                    window.location.href = 'sentiment.php';
                },
                error: function (xhr, status, error) {
                    // Handle errors with an alert
                    alert('Error: ' + error);
                }
            });
        } else {
            // Alert if no review IDs were found
            alert('No review IDs found to process.');
        }
    });
});

