<style>
      #datatablesSimpleDtr {
            font-size: 14px;
            border-collapse: collapse;
            width: 100%;
      }

      #datatablesSimpleDtr th,
      #datatablesSimpleDtr td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
      }

      #datatablesSimpleDtr thead th {
            background-color: #343a40;
            color: white;
            position: sticky;
            top: 0;
            z-index: 2;
      }

      #datatablesSimpleDtr tbody tr:nth-child(even) {
            background-color: #f2f2f2;
      }

      #datatablesSimpleDtr tbody tr:hover {
            background-color: #ddd;
      }

      #datatablesSimpleDtr tbody tr:hover {
            background-color: #ffeb3b !important;
            cursor: pointer;
      }

      .table-responsive {
            overflow-x: auto;
            white-space: nowrap;
            max-width: 100%;
      }
</style>
<!-- <?=json_encode($dtrView)?>  -->
<div class="table-responsive">
      <table id="datatablesSimpleDtr" class="table table-striped">
            <thead class="table-dark">
                  <tr>
                        <th>DAYS OF THE WEEK</th>
                        <th>SHIFT</th>
                        <th>DATE</th>

                        <th colspan="2">WORK TIME</th>

                        <th>REMARKS</th>

                        <th colspan="2">REG WORK</th>
                        <th colspan="2">ABSENCES</th>
                        <th colspan="2">COMPENSATORY TIME-OFF</th>
                        <th colspan="2">LEAVES W/ PAY</th>
                        <th colspan="2">LEAVES W/O PAY</th>

                        <th>LATES</th>
                        <th>UT</th>

                        <th colspan="2">REG OT</th>

                        <th colspan="3">LEGAL HOLIDAY OT</th>
                        <th colspan="3">LEGAL REST DAY OT</th>
                        <th colspan="3">REST DAY OT</th>
                        <th colspan="3">SPECIAL HOLIDAY OT</th>
                        <th colspan="3">SPECIAL HOLIDAY REST DAY OT</th>
                  </tr>
                  <tr>
                        <th></th>
                        <th></th>
                        <th></th>

                        <th>IN</th>
                        <th>OUT</th>

                        <th></th>

                        <th>DAYS</th>
                        <th>HRS</th>

                        <th>(DAYS)</th>
                        <th>(HRS)</th>

                        <th>(DAYS)</th>
                        <th>(HRS)</th>

                        <th>(DAYS)</th>
                        <th>(HRS)</th>

                        <th>(DAYS)</th>
                        <th>(HRS)</th>

                        <th>(HRS)</th>
                        <th>(HRS)</th>

                        <th>(8HRS)</th>
                        <th>(ND)</th>

                        <th>(8HRS)</th>
                        <th>(>8HRS)</th>
                        <th>(ND)</th>

                        <th>(8HRS)</th>
                        <th>(>8HRS)</th>
                        <th>(ND)</th>

                        <th>(8HRS)</th>
                        <th>(>8HRS)</th>
                        <th>(ND)</th>

                        <th>(8HRS)</th>
                        <th>(>8HRS)</th>
                        <th>(ND)</th>

                        <th>(8HRS)</th>
                        <th>(>8HRS)</th>
                        <th>(ND)</th>
                  </tr>
            </thead>
            <tbody>
                  <?php if (!empty($dtrView['rows'])): ?>

                  @foreach($dtrView['rows'] as $rows)

                                <tr>
                                          <td class="text-start"><?= htmlspecialchars($rows->days_of_week); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->shift); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->date); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->timeIN); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->timeOUT); ?></td>


                                          <td class="text-start"><?= htmlspecialchars($rows->remarks); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->reg_work_days); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->reg_work_hrs); ?></td>


                                          <td class="text-start"><?= htmlspecialchars($rows->absent_days); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->absent_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->cto_days); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->cto_hrs); ?></td>

                                          
                                          <td class="text-start"><?= htmlspecialchars($rows->lwp_days); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->lwp_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->lwop_days); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->lwop_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->late_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->undertime_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->reg_ot_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->reg_nd_ot_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->legal_ot_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->legal_ot_exceeds_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->legal_nd_ot_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->legal_rd_ot_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->legal_rd_ot_exceeds_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->legal_rd_nd_ot_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->reg_rd_ot_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->reg_rd_ot_exceeds_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->reg_rd_nd_ot_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->spcl_ot_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->spcl_ot_exceeds_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->spcl_nd_ot_hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->spcl_rd_ot_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->spcl_rd_ot_exceeds_8hrs); ?></td>
                                          <td class="text-start"><?= htmlspecialchars($rows->spcl_rd_nd_ot_hrs); ?></td>
                                </tr>
                          @endforeach
                  <?php else: ?>
                  <tr>
                        <td colspan="35" class="text-center">No Records found</td>
                  </tr>
                  <?php endif; ?>
            </tbody>
      </table>
</div>