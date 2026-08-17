$(document).ready(function () {
    const table = $('#notificationsTable').DataTable({
        pageLength: 10,
        order: [[3, 'desc']],
        columnDefs: [{ orderable: false, targets: [0, 1] }]
    });

    $('#notificationsFilterGroup .btn').on('click', function () {
        $('#notificationsFilterGroup .btn').removeClass('active');
        $(this).addClass('active');
        const filter = $(this).data('filter');

        if (filter === 'all') {
            $('#notificationsTable tbody tr').show();
        } else {
            $('#notificationsTable tbody tr').each(function () {
                $(this).toggle($(this).data('type') === filter);
            });
        }
    });
});
