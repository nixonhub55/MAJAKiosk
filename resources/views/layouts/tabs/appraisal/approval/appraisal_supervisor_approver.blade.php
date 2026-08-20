@extends('layouts.admin')

<script>
    let currentPage = 1;
    const totalPages = 7;

    function nextPage() {
        if (currentPage < totalPages) {
            document.getElementById(`page-${currentPage}`).classList.add('d-none');
            currentPage++;
            document.getElementById(`page-${currentPage}`).classList.remove('d-none');
            updatePage();
            window.scrollTo(0, 0);
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            document.getElementById(`page-${currentPage}`).classList.add('d-none');
            currentPage--;
            document.getElementById(`page-${currentPage}`).classList.remove('d-none');
            updatePage();
            window.scrollTo(0, 0);
        }
    }

    function updatePage() {
        document.getElementById('pageNumber').innerText = currentPage;
        document.getElementById('totalPages').innerText = totalPages;
    }

    // Calculate Gap when Required or Actual changes
    document.addEventListener('DOMContentLoaded', function() {
        const requiredInputs = document.querySelectorAll('.required');
        const actualInputs = document.querySelectorAll('.actual');

        function calculateGaps() {
            requiredInputs.forEach((input, index) => {
                const required = parseFloat(input.value) || 0;
                const actual = parseFloat(actualInputs[index].value) || 0;
                const gap = required - actual;
                const gapField = document.getElementById(`gap${index}`);
                if (gapField) {
                    gapField.value = gap !== 0 ? gap : '';
                }
            });
        }

        requiredInputs.forEach(input => input.addEventListener('input', calculateGaps));
        actualInputs.forEach(input => input.addEventListener('input', calculateGaps));
    });
</script>
@section('content')


<style>
    .appraisal-container {
        max-width: 950px;
      margin: 20px auto 80px auto;
        background: white;
        padding: 30px;
        font-family: Arial, sans-serif;
    }

    .appraisal-header {
        text-align: center;
        border-bottom: 3px solid #333;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .appraisal-title {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
    }

    .appraisal-subtitle {
        font-size: 12px;
        margin: 3px 0;
    }

    .page-indicator {
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .form-section-title {
        font-size: 13px;
        font-weight: bold;
        background-color: #333;
        color: white;
        border: 1px solid #333;
        padding: 8px 10px;
        margin: 20px 0 15px 0;
    }

    .form-section-title-light {
        font-size: 13px;
        font-weight: bold;
        background-color: #f0f0f0;
        border: 1px solid #333;
        padding: 8px 10px;
        margin: 20px 0 15px 0;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .info-table td {
        border: 1px solid #999;
        padding: 8px 10px;
        font-size: 13px;
    }

    .info-table .label {
        background-color: #f5f5f5;
        font-weight: bold;
        width: 23%;
    }

    .info-table input,
    .info-table textarea {
        width: 100%;
        border: none;
        padding: 4px;
        font-family: Arial, sans-serif;
        font-size: 13px;
    }

    .guide-box {
        border: 2px solid #333;
        padding: 12px;
        margin: 20px 0;
        font-size: 12px;
        background-color: #fafafa;
    }

    .guide-box strong {
        display: block;
        margin-bottom: 8px;
        text-decoration: underline;
    }

    .guide-box div {
        margin: 4px 0;
        line-height: 1.4;
    }

    .competency-table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0;
        font-size: 11px;
    }

    .competency-table thead th {
        background-color: #333;
        color: white;
        border: 1px solid #333;
        padding: 8px;
        text-align: center;
        font-weight: bold;
    }

    .competency-table tbody td {
        border: 1px solid #999;
        padding: 6px;
        font-size: 10px;
    }

    .competency-table .competency-name {
        font-weight: bold;
        text-align: left;
    }

    .competency-table .competency-desc {
        font-size: 9px;
        color: #666;
        margin-top: 2px;
        line-height: 1.2;
    }

    .competency-table input[type="number"],
    .competency-table input[type="text"] {
        width: 100%;
        padding: 3px;
        border: 1px solid #ccc;
        font-size: 11px;
        text-align: center;
    }

    .competency-table input[readonly] {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    .checkbox-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .checkbox-group input[type="checkbox"] {
        width: auto;
        cursor: pointer;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: 25px;
        gap: 10px;
    }

    .button-group button {
        padding: 10px 25px;
        font-size: 14px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        border-radius: 3px;
    }

    .btn-next {
        background-color: #007bff;
        color: white;
        margin-left: auto;
    }

    .btn-next:hover {
        background-color: #0056b3;
    }

    .btn-prev {
        background-color: #6c757d;
        color: white;
    }

    .btn-prev:hover {
        background-color: #545b62;
    }

    .btn-submit {
        background-color: #28a745;
        color: white;
    }

    .btn-submit:hover {
        background-color: #218838;
    }

    .important-note {
        background-color: #fff3cd;
        border: 1px solid #ffc107;
        padding: 12px;
        margin: 15px 0;
        font-size: 11px;
        line-height: 1.5;
    }

    .important-note strong {
        display: block;
        margin-bottom: 5px;
    }

    .rating-scale-table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
        font-size: 11px;
    }

    .rating-scale-table td {
        border: 1px solid #999;
        padding: 6px;
    }

    .rating-scale-table .label {
        font-weight: bold;
        background-color: #f5f5f5;
    }

    .checkbox-cell {
        text-align: center;
    }

    .checkbox-cell input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .grid-2-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .d-none {
        display: none !important;
    }
</style>

<div class="appraisal-container">
    <form method="POST">
        @csrf

        <!-- HEADER -->
        <div class="appraisal-header">
            <p class="appraisal-title">PERFORMANCE APPRAISAL FORM</p>
            <p class="appraisal-subtitle">(For Supervisory and Confidential Position)</p>
            <p class="appraisal-subtitle">CONFIDENTIAL</p>
        </div>

        <!-- PAGE INDICATOR -->
        <div class="page-indicator">
            Page <span id="pageNumber">1</span> of <span id="totalPages">7</span>
        </div>

        <!-- ================= PAGE 1 ================= -->
        <div id="page-1">
 
            <!-- EMPLOYEE INFORMATION -->
            <div class="form-section-title">EMPLOYEE INFORMATION</div>
 
            <table class="info-table">
                <tr>
                    <td class="label">Employee Name</td>
                    <td colspan="3"><input type="text" name="employee_name" required></td>
                </tr>
                <tr>
                    <td class="label">Position</td>
                    <td colspan="3"><input type="text" name="position" required></td>
                </tr>
                <tr>
                    <td class="label">Division/Department</td>
                    <td colspan="3"><input type="text" name="department" required></td>
                </tr>
                <tr>
                    <td class="label">Date Hired</td>
                    <td><input type="date" name="date_hired" required></td>
                    <td class="label" style="width: 15%; text-align: right; padding-right: 10px;">Period From</td>
                    <td><input type="date" name="period_from" required></td>
                </tr>
                <tr>
                    <td class="label">Date of Appraisal</td>
                    <td><input type="date" name="date_appraisal" required></td>
                    <td class="label" style="width: 15%; text-align: right; padding-right: 10px;">Period To</td>
                    <td><input type="date" name="period_to"></td>
                </tr>
            </table>
 
            <!-- IMPORTANT NOTE -->
            <div class="important-note">
                <strong>NOTE:</strong>
                This Performance Appraisal Form aims to provide a formal, recorded, regular review of an individual's performance and competencies. It is to be used for annual evaluations, and at other times during the year when formal feedback is needed.
                <br><br>
                <strong>This is a four (4) part Appraisal Form which are as follows:</strong>
                <br><br>
                <strong>Part I – Competencies Assessment</strong><br>
                These include knowledge, skills and basic competencies. Rate each factor based on performance during the period identified above.
                <br><br>
                <strong>Part II – Goals from previous year or previous evaluation period</strong><br>
                Rate employee's performance on each goal established at the beginning of the period.
                <br><br>
                <strong>Part III – Goals for the coming year or evaluation period</strong><br>
                Input the agreed performance goals for the next period to be evaluated.
                <br><br>
                <strong>Part IV – Individual Development Plan</strong><br>
                Action plan on how to close the competency gap/s improve future employee performance.
            </div>
 
            <!-- RATING GUIDE -->
            <div class="guide-box">
                <strong>RATING SCALE:</strong>
                <div class="grid-2-col">
                    <div>
                        <strong style="display: inline; text-decoration: none; margin-bottom: 5px; display: block;">CORE COMPETENCIES</strong>
                        5 - EXCEPTIONAL PERFORMANCE<br>
                        4 - EXCEEDS EXPECTATIONS<br>
                        3 - MEETS EXPECTATIONS<br>
                        2 - IMPROVEMENT DESIRED<br>
                        1 - UNSATISFACTORY
                    </div>
                    <div>
                        <strong style="display: inline; text-decoration: none; margin-bottom: 5px; display: block;">JOB-SPECIFIC COMPETENCIES</strong>
                        5 - EXPERT / CONSULTANT<br>
                        4 - CAN WORK AND TEACH<br>
                        3 - CAN WORK ALONE<br>
                        2 - CAN WORK WITH MUCH SUPERVISION<br>
                        1 - CANNOT PERFORM
                    </div>
                </div>
            </div>
 
            <div class="button-group">
                <button type="button" class="btn-next" onclick="nextPage()">Next &raquo;</button>
            </div>
 
        </div>

        <!-- ================= PAGE 2 ================= -->
        <div id="page-2" class="d-none">

            <div class="form-section-title">PART I - COMPETENCY ASSESSMENT</div>

            <div style="font-size: 11px; margin-bottom: 10px;">
                <strong>(Please rate the employee based on the following competencies.)</strong>
            </div>

            <div style="overflow-x: auto;">
                <table class="competency-table">
                    <thead>
                        <tr>
                            <th width="30%">A. CORE COMPETENCY</th>
                            <th width="12%">REQUIRED<br>PROFICIE</th>
                            <th width="12%">ACTUAL<br>PROFICIENCY</th>
                            <th width="8%">GAP</th>
                            <th width="38%">REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $competencies = [
                                [
                                    'name' => 'PEOPLE MANAGEMENT',
                                    'desc' => 'Ability to organize and supervise people, assist subordinates in achieving expected results with understanding and management of human relations.'
                                ],
                                [
                                    'name' => 'ORGANIZATIONAL SKILLS',
                                    'desc' => 'Ability to establish priorities and plan, and manage work schedule, arrange and organize available resources to enhance productivity.'
                                ],
                                [
                                    'name' => 'JUDGMENT',
                                    'desc' => 'Capacity to assess facts objectively, distinguish problems, and make sound decisions based on available information.'
                                ],
                                [
                                    'name' => 'LEADERSHIP',
                                    'desc' => 'The ability to command confidence and induce cooperation and commendable performance through effective communication and direction.'
                                ],
                                [
                                    'name' => 'COMMUNICATION',
                                    'desc' => 'Ability to express ideas clearly to subordinates and customers, actively listening, clearly and accurately written communication skills.'
                                ],
                                [
                                    'name' => 'INTERPERSONAL RELATIONS',
                                    'desc' => 'Ability and readiness to establish effective relationships with associates, superiors and others on the job, demonstrates respect, courtesy, tact and cooperativeness.'
                                ],
                                [
                                    'name' => 'TECHNICAL AND PROFESSIONAL KNOWLEDGE',
                                    'desc' => 'The degree of expertise in the application of theories and factors related to the technical aspects of the job and consistent application of technical knowledge to accomplish job objectives effectively.'
                                ],
                                [
                                    'name' => 'INTEGRITY',
                                    'desc' => 'The ability and willingness to adhere to principles of the company.'
                                ],
                                [
                                    'name' => 'ATTITUDE',
                                    'desc' => 'Demonstrates a positive work attitude and enthusiasm about the job.'
                                ],
                                [
                                    'name' => 'CUSTOMER ORIENTATION',
                                    'desc' => 'Values the importance of delivering high-quality service and is oriented towards external clients; understands the needs of the client, and ensures customer service focus.'
                                ]
                            ];
                        @endphp

                        @foreach($competencies as $i => $comp)
                            <tr>
                                <td>
                                    <div class="competency-name">{{ $comp['name'] }}</div>
                                    <div class="competency-desc">{{ $comp['desc'] }}</div>
                                </td>
                                <td style="text-align: center;">
                                    <input type="number" name="core_required[]" class="form-control required"
                                        data-index="{{ $i }}" min="1" max="5" required>
                                </td>
                                <td style="text-align: center;">
                                    <input type="number" name="core_actual[]" class="form-control actual"
                                        data-index="{{ $i }}" min="1" max="5" required>
                                </td>
                                <td style="text-align: center;">
                                    <input type="text" name="core_gap[]" id="gap{{ $i }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="core_remarks[]">
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="important-note">
                <strong>LEGEND:</strong><br>
                EXPERT / CONSULTANT = 5<br>
                CAN WORK AND TEACH = 4<br>
                MEETS EXPECTATIONS = 3<br>
                CAN WORK WITH MUCH SUPERVISION = 2<br>
                CANNOT PERFORM = 1
            </div>

            <div class="button-group">
                <button type="button" class="btn-prev" onclick="prevPage()">« Previous</button>
                <button type="button" class="btn-next" onclick="nextPage()">Next &raquo;</button>
            </div>

        </div>

        <!-- ================= PAGE 3 ================= -->
        <div id="page-3" class="d-none">

            <div class="form-section-title">B. JOB-SPECIFIC COMPETENCY</div>

            <div style="overflow-x: auto;">
                <table class="competency-table">
                    <thead>
                        <tr>
                            <th width="40%">JOB-SPECIFIC COMPETENCY</th>
                            <th width="12%">REQUIRED<br>PROFICIE</th>
                            <th width="12%">ACTUAL<br>PROFICIENCY</th>
                            <th width="8%">GAP</th>
                            <th width="28%">REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < 10; $i++)
                            <tr>
                                <td>
                                    <input type="text" name="job_specific_competency[]" placeholder="Competency {{ $i + 1 }}" style="width: 100%; border: none; padding: 4px;">
                                </td>
                                <td style="text-align: center;">
                                    <input type="number" name="job_required[]" class="form-control" min="1" max="5">
                                </td>
                                <td style="text-align: center;">
                                    <input type="number" name="job_actual[]" class="form-control" min="1" max="5">
                                </td>
                                <td style="text-align: center;">
                                    <input type="text" name="job_gap[]" id="jobgap{{ $i }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="job_remarks[]">
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <div class="important-note">
                <strong>Please use separate sheet if necessary</strong>
            </div>

            <div class="guide-box">
                <strong>RATING SCALE:</strong><br>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 5px;"><strong>EXPERT / CONSULTANT</strong></td>
                        <td style="padding: 5px; text-align: center;"><strong>5</strong></td>
                        <td style="padding: 5px; text-align: right;"><strong>EQUIVALENT SCORE<br>(For computation purposes only)</strong></td>
                        <td style="padding: 5px; text-align: center;"><strong>9</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;"><strong>CAN WORK AND TEACH</strong></td>
                        <td style="padding: 5px; text-align: center;"><strong>4</strong></td>
                        <td style="padding: 5px; text-align: right;"></td>
                        <td style="padding: 5px; text-align: center;"><strong>7</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;"><strong>CAN WORK ALONE</strong></td>
                        <td style="padding: 5px; text-align: center;"><strong>3</strong></td>
                        <td style="padding: 5px; text-align: right;"></td>
                        <td style="padding: 5px; text-align: center;"><strong>5</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;"><strong>CAN WORK WITH MUCH SUPERVISION</strong></td>
                        <td style="padding: 5px; text-align: center;"><strong>2</strong></td>
                        <td style="padding: 5px; text-align: right;"></td>
                        <td style="padding: 5px; text-align: center;"><strong>3</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;"><strong>CANNOT PERFORM</strong></td>
                        <td style="padding: 5px; text-align: center;"><strong>1</strong></td>
                        <td style="padding: 5px; text-align: right;"></td>
                        <td style="padding: 5px; text-align: center;"><strong>1</strong></td>
                    </tr>
                </table>
            </div>

            <div class="button-group">
                <button type="button" class="btn-prev" onclick="prevPage()">« Previous</button>
                <button type="button" class="btn-next" onclick="nextPage()">Next &raquo;</button>
            </div>

        </div>

        <!-- ================= PAGE 4 ================= -->
        <div id="page-4" class="d-none">

            <div class="form-section-title">PART II - GOALS COVERED UNDER THE EVALUATION PERIOD</div>

            <div style="font-size: 11px; margin-bottom: 10px;">
                <strong>(Please check appropriate box. If none, explain below.)</strong>
            </div>

            <table class="competency-table">
                <thead>
                    <tr>
                        <th width="35%">GOALS</th>
                        <th style="text-align: center;">FA</th>
                        <th style="text-align: center;">FE</th>
                        <th style="text-align: center;">ME</th>
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">UP</th>
                        <th width="20%">COMMENTS</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 1; $i <= 11; $i++)
                        <tr>
                            <td>
                                <input type="text" name="goals[]" placeholder="Goal {{ $i }}" style="width: 100%; border: none; padding: 4px;">
                            </td>
                            <td class="checkbox-cell"><input type="checkbox" name="goal_fa[]" value="1"></td>
                            <td class="checkbox-cell"><input type="checkbox" name="goal_fe[]" value="1"></td>
                            <td class="checkbox-cell"><input type="checkbox" name="goal_me[]" value="1"></td>
                            <td class="checkbox-cell"><input type="checkbox" name="goal_id[]" value="1"></td>
                            <td class="checkbox-cell"><input type="checkbox" name="goal_up[]" value="1"></td>
                            <td>
                                <input type="text" name="goal_comments[]" style="width: 100%; padding: 4px; border: 1px solid #ccc;">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div style="margin-top: 15px; font-size: 11px;">
                <strong>LEGEND:</strong><br>
                FA = Fully Achieved | FE = Fully Exceeded | ME = Meets Expectation | ID = Improvement Desired | UP = Under Progress
            </div>

            <div class="button-group">
                <button type="button" class="btn-prev" onclick="prevPage()">« Previous</button>
                <button type="button" class="btn-next" onclick="nextPage()">Next &raquo;</button>
            </div>

        </div>

        <!-- ================= PAGE 5 ================= -->
        <div id="page-5" class="d-none">

            <div class="form-section-title">PART III - KEY PERFORMANCE INDICATORS</div>

            <table class="competency-table">
                <thead>
                    <tr>
                        <th width="35%">GOAL</th>
                        <th width="35%">KEY PERFORMANCE INDICATORS</th>
                        <th width="30%">REMARKS</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>
                                <input type="text" name="kpi_goal[]" placeholder="Goal {{ $i }}" style="width: 100%; border: none; padding: 4px;">
                            </td>
                            <td>
                                <input type="text" name="kpi_indicator[]" placeholder="KPI {{ $i }}" style="width: 100%; border: none; padding: 4px;">
                            </td>
                            <td>
                                <input type="text" name="kpi_remarks[]" style="width: 100%; padding: 4px; border: 1px solid #ccc;">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div class="button-group">
                <button type="button" class="btn-prev" onclick="prevPage()">« Previous</button>
                <button type="button" class="btn-next" onclick="nextPage()">Next &raquo;</button>
            </div>

        </div>

        <!-- ================= PAGE 6 ================= -->
        <div id="page-6" class="d-none">

            <div class="form-section-title">PART IV - INDIVIDUAL DEVELOPMENT PLAN</div>

            <table class="competency-table">
                <thead>
                    <tr>
                        <th width="30%">SUMMARY OF COMPETENCY GAPS</th>
                        <th width="15%">REQUIRED</th>
                        <th width="15%">ACTUAL</th>
                        <th width="15%">GAP</th>
                        <th width="25%">DEVELOPMENTAL ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 1; $i <= 5; $i++)
                        <tr>
                            <td>
                                <input type="text" name="dev_gap_summary[]" placeholder="Competency gap {{ $i }}" style="width: 100%; border: none; padding: 4px;">
                            </td>
                            <td style="text-align: center;">
                                <input type="number" name="dev_required[]" min="1" max="5" style="width: 100%; padding: 4px; text-align: center; border: 1px solid #ccc;">
                            </td>
                            <td style="text-align: center;">
                                <input type="number" name="dev_actual[]" min="1" max="5" style="width: 100%; padding: 4px; text-align: center; border: 1px solid #ccc;">
                            </td>
                            <td style="text-align: center;">
                                <input type="text" name="dev_gap[]" id="devgap{{ $i }}" style="width: 100%; padding: 4px; text-align: center; background-color: #f5f5f5;" readonly>
                            </td>
                            <td>
                                <input type="text" name="dev_action[]" style="width: 100%; padding: 4px; border: 1px solid #ccc;">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div class="button-group">
                <button type="button" class="btn-prev" onclick="prevPage()">« Previous</button>
                <button type="button" class="btn-next" onclick="nextPage()">Next &raquo;</button>
            </div>

        </div>

        <!-- ================= PAGE 7 ================= -->
        <div id="page-7" class="d-none">

            <div class="form-section-title">COMPUTATION OF PERFORMANCE RATING</div>

            <div class="guide-box">
                <strong>PERFORMANCE RATING = COMPETENCIES + GOALS</strong><br><br>
                To Compute for Competencies:<br>
                Competencies = Average Score of all Specific Competencies + Average Score of all Job Specific Competencies ÷ 2<br><br>
                To Compute for Goals:<br>
                Goals = Average score of Goals covered under the evaluation period x 70%
            </div>

            <div style="margin: 20px 0;">
                <p><strong>Performance Rating = _____ Competencies + _____ Goals</strong></p>
            </div>

            <div class="form-section-title">OVERALL PERFORMANCE EVALUATION</div>

            <table class="competency-table">
                <thead>
                    <tr>
                        <th width="15%">EX<br>(1)</th>
                        <th width="15%">CC<br>(2)</th>
                        <th width="15%">ME<br>(3)</th>
                        <th width="15%">D<br>(4)</th>
                        <th width="15%">UP<br>(5)</th>
                        <th width="25%">COMMENTS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="checkbox-cell"><input type="checkbox" name="overall_ex" value="1"></td>
                        <td class="checkbox-cell"><input type="checkbox" name="overall_cc" value="1"></td>
                        <td class="checkbox-cell"><input type="checkbox" name="overall_me" value="1"></td>
                        <td class="checkbox-cell"><input type="checkbox" name="overall_d" value="1"></td>
                        <td class="checkbox-cell"><input type="checkbox" name="overall_up" value="1"></td>
                        <td>
                            <textarea name="overall_comments" style="width: 100%; height: 60px; padding: 4px; border: 1px solid #ccc;"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div style="margin-top: 15px; font-size: 11px;">
                <strong>LEGEND:</strong><br>
                EX = Exceptional | CC = Consistently Competent | ME = Meets Expectation | D = Developing | UP = Unsatisfactory Performance
            </div>

            <div class="button-group">
                <button type="button" class="btn-prev" onclick="prevPage()">« Previous</button>
                <button type="submit" class="btn-submit">SUBMIT</button>
            </div>

        </div>

    </form>
</div>

@endsection