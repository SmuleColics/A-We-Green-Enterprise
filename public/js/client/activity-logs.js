$(document).ready(function () {
    const table = $('#activityTable').DataTable({
        pageLength: 10,
        order: [[4, 'desc']],
        columnDefs: [{ orderable: false, targets: [0, 5] }]
    });

    $('#activityFilterGroup .btn').on('click', function () {
        $('#activityFilterGroup .btn').removeClass('active');
        $(this).addClass('active');
        const filter = $(this).data('filter');

        if (filter === 'all') {
            table.column(1).search('').draw();
            $('#activityTable tbody tr').show();
        } else {
            $('#activityTable tbody tr').each(function () {
                $(this).toggle($(this).data('type') === filter);
            });
        }
    });
});