

<table id="datatablesSimpleLeave" class="table table-striped">
      <thead class="table-dark">
            <tr> 
                  <th>Day</th>
                  <th>Shift</th>
                  <th>Date</th>
                  <!-- <th>Work Time</th> -->
                  <th>Remarks</th>
                  <th>Reg Work</th>
                  <th>Absences</th>
                  <!-- <th>Compensatory time-off</th>
                  <th>Leave w/ pay</th>
                  <th>Leave w/o pay</th>
                  <th>Lates</th>
                  <th>UT</th>
                  <th>Reg OT</th>
                  <th>Legal holiday OT</th>
                  <th>Legal holiday rest day OT</th>
                  <th>Rest day OT</th>
                  <th>Special holiday OT</th>
                  <th>Special holiday rest day OT</th> -->
            </tr>
      </thead>
      <tbody>
            <?php if (!empty($dtrView)): ?>

            @foreach($dtrView['rows'] as $rows)

                        <tr>
                        <td class="text-start"><?= htmlspecialchars($rows->cto_days); ?></td> 
                        <td class="text-start"><?= htmlspecialchars($rows->shift); ?></td>
                              <td class="text-start"><?= htmlspecialchars($rows->date); ?></td>
                              <td class="text-start"><?= htmlspecialchars($rows->remarks); ?></td>
                              <td class="text-start"><?= htmlspecialchars($rows->reg_work_days); ?></td>
                              <!-- <td class="text-start"><?= htmlspecialchars($rows->reg_work_hrs); ?></td> -->
                              <td class="text-start"><?= htmlspecialchars($rows->absent_days); ?></td>
                             <!--  <td class="text-start"><?= htmlspecialchars($rows->absent_hrs); ?></td> -->
                             <!--  <td class="text-start"><?= htmlspecialchars($rows->cto_days); ?></td> -->
                              <!-- <td class="text-start"><?= htmlspecialchars($rows->cto_hrs); ?></td> -->
                              <!-- <td class="text-start"><?= htmlspecialchars($rows->lwp_days); ?></td>
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
                              <td class="text-start"><?= htmlspecialchars($rows->spcl_rd_nd_ot_hrs); ?></td> -->
                        </tr>
                  @endforeach
            <?php else: ?>
            <tr>
                  <td colspan="6" class="text-center">No leave balances found</td>
            </tr>
            <?php endif; ?>
      </tbody>
</table>