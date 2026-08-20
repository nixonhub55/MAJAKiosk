<table id="datatablesSimpleLeave" class="table table-striped">
    <thead class="table-header">
        <tr>
            <th>#</th>
            <th>Leave Type</th>
            <th>Balance Leave</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        if (!empty($leaveBalance)): ?>
        <?php    $index = 0; ?>
        @foreach($leaveBalance['rows'] as $rows)
            <?php        $index += 1; ?>
            <tr>
                <td><?= $index ?></td>
                <td class="text-start"><?= htmlspecialchars($rows->leaveName); ?></td>
                <td class="text-start"><?= htmlspecialchars($rows->currentBalance); ?></td>
            </tr>
        @endforeach
        <?php else: ?>
        <tr>
            <td colspan="3" class="text-center">No leave balances found</td>
        </tr>
        <?php endif; ?>
    </tbody>

</table>

<script>
     
    var datatablesSimpleLeave = document.getElementById('datatablesSimpleLeave');
    if (datatablesSimpleLeave) {
        new simpleDatatables.DataTable(datatablesSimpleLeave, {
            searchable: true,
            perPage: 5,
            sortable: true
        });
    } 

</script>