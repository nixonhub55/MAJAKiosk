<table id="datatablesSimpleBio" class="table table-striped">
        <thead class="table-header">
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Type</th>
                <th>Biometrics ID</th>
                <th>Machine ID</th>

            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dtrLogs)): ?>

            @foreach($dtrLogs['rows'] as $rows)

                <tr>
                    <td class="text-start"><?= htmlspecialchars($rows->date); ?></td>
                    <td class="text-start"><?= htmlspecialchars($rows->time); ?></td>
                    <td class="text-start"><?= htmlspecialchars($rows->dtrType); ?></td>
                    <td class="text-start"><?= htmlspecialchars($rows->biometricsId); ?></td>
                    <td class="text-start"><?= htmlspecialchars($rows->machineID); ?></td>
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
     
    var datatablesSimpleBio = document.getElementById('datatablesSimpleBio');
    if (datatablesSimpleBio) {
        new simpleDatatables.DataTable(datatablesSimpleBio, {
            searchable: true,
            perPage: 5,
            sortable: true
        });
    } 

</script>