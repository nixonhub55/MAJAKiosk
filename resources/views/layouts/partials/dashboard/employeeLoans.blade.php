 
<table id="datatablesSimpleLoans" class="table table-striped">
    <thead class="table-header">
        <tr>
            <th></th>
            <th>Loan Description</th>
            <th>Loan Date</th>
            <th>Loan Amount</th>
            <th>Interest</th>
            <th>Amortization</th>
            <th>Date Effective</th>
            <th>Date End</th> 
        </tr>
    </thead>
    <tbody>
        <?php 
        
        if (!empty($loans)): ?>
        <?php    $index = 0; ?>
        @foreach($loans['rows'] as $rows)
            <?php        $index += 1; ?>
            <tr>
                <td><?= $index ?></td>
                <td class="text-start"><?= htmlspecialchars($rows->deductionName); ?></td>
                <td class="text-start"><?= htmlspecialchars($rows->loanDate); ?></td>
                <td class="text-start"><?= htmlspecialchars($rows->loanAmount); ?></td>
                <td class="text-start"><?= htmlspecialchars($rows->interest); ?></td>
                <td class="text-start"><?= htmlspecialchars($rows->amount); ?></td>
                <td class="text-start"><?= htmlspecialchars($rows->dateEffective); ?></td>
                <td class="text-start"><?= htmlspecialchars($rows->dateEnd); ?></td>
            </tr>
        @endforeach
        <?php else: ?>
        <tr>
            <td colspan="7" class="text-center">No loans found!</td>
        </tr>
        <?php endif; ?>
    </tbody>

</table>

<script>
     
    var datatablesSimpleLoans = document.getElementById('datatablesSimpleLoans');
    if (datatablesSimpleLoans) {
        new simpleDatatables.DataTable(datatablesSimpleLoans, {
            searchable: true,
            perPage: 5,
            sortable: true
        });
    } 

</script>