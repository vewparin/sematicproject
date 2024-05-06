$(document).ready(function() {
    $('#allAnalyzeBtn').click(function() {
        var reviewIds = [];
        $('table tr').each(function() {
            var id = $(this).find('td:first').text();
            if (id !== 'ID') {
                reviewIds.push(id);
            }
        });

        $.ajax({
            url: 'processAllAnalyze.php',
            type: 'POST',
            data: {reviewIds: reviewIds},
            success: function(response) {
                window.location.href = 'sentiment.php';
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
});