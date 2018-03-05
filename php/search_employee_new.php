<?PHP
session_start();
include("../config/config.php");
?>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Employee Details&nbsp;
                    <span id="show_office">

                    </span>
                    <?PHP
					if(isset($_SESSION['Office']))
                    echo "&nbsp;(".$_SESSION['Office'].")";?>
                </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">

          <div id="div_message" class="callout callout-danger" style="display:none">
          </div>

          <div id="show_emp_form">
            <div class="box-header">
              <a class="btn btn-app" data-target="personal" data-value="ON">
                <span class="badge bg-green"><i class="fa fa-check"></i></span>
                <i class="fa fa-user text-red icon"></i> Personal
              </a>
              <a class="btn btn-app" data-target="contact" data-value="OFF">
                <i class="fa fa-phone icon"></i> Contact
              </a>
              <a class="btn btn-app" data-target="salary" data-value="OFF">
                <i class="fa fa-inr icon"></i> Salary
              </a>
              <a class="btn btn-app" data-target="additional" data-value="OFF">
                <i class="fa fa-plus-square icon"></i> Additional
              </a>
              <a class="btn btn-app" data-target="bank" data-value="OFF">
                <i class="fa fa-bank icon"></i> Bank
              </a>
              <a class="btn btn-app" data-target="epic" data-value="OFF">
                <i class="fa fa-question-circle icon"></i> Epic
              </a>
              <a class="btn btn-app" data-target="assembly" data-value="OFF">
                <i class="fa fa-globe icon"></i> Assembly
              </a>
              <a class="btn btn-app" data-target="blockmuni" data-value="OFF">
                <i class="fa fa-map-marker icon"></i> Block/Municipality
              </a>
            </div>
            <!-- /.box-header -->
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-warning" id="report_panel">
                  <div class="panel-heading text-bold" id="report_result"><i class="fa fa-info-circle text-blue"></i> Personal, Salary and Additional Details may be Locked for some Employees</div>
                </div>
              </div>
            </div>
            <!-- End Row 3 -->
            <div class="overlay text-center" align="center">
              <img src="img/ajax_loader_green_128.gif" width="50" height="50" />
              <small> Loading...</small>
            </div>
            <table id="table_employee" class="table table-bordered table-condensed small" style="display:none">
              <thead>
                <tr class="bg-blue-gradient">
                  <th class="index empcode">EMPLOYEE CODE</th>
                  <th class="index name">EMPLOYEE NAME</th>
                  <th class="personal desg">DESIGNATION</th>
                  <th class="personal gender">GENDER</th>
                  <th class="personal dob">DATE OF BIRTH</th>
                  <th class="contact present_addr1">PRESENT ADDRESS 1</th>
                  <th class="contact present_addr2">PRESENT ADDRESS 2</th>
                  <th class="contact perm_addr1">PERMANENT ADDRESS 1</th>
                  <th class="contact perm_addr2">PERMANENT ADDRESS 2</th>
                  <th class="contact email">EMAIL ID</th>
                  <th class="contact resi_no">PHONE</th>
                  <th class="contact mob_no">MOBILE</th>
                  <th class="salary scale">SCALE OF PAY</th>
                  <th class="salary basic_pay">BASIC PAY</th>
                  <th class="salary grade_pay">GRADE PAY</th>
									<th class="salary group">GROUP</th>
                  <th class="additional qualificationcd">QUALIFICATION</th>
                  <th class="additional workingstatus">WORKING FOR 3 YEARS</th>
                  <th class="additional languagecd">LANGUAGE KNOWN</th>
                  <th class="additional remarks">REMARKS</th>
                  <th class="bank bank_cd">BANK NAME</th>
                  <th class="bank branchname">BRANCH NAME</th>
                  <th class="bank branchcd">BRANCH IFSC</th>
                  <th class="bank bank_acc_no">BANK ACCOUNT NO</th>
                  <th class="epic epic_no">EPIC NO</th>
                  <th class="epic partno">PART NO</th>
                  <th class="epic slno">SL NO</th>
                  <th class="assembly assembly_temp">PRESENT ASSEMBLY</th>
                  <th class="assembly assembly_perm">PERMANENT ASSEMBLY</th>
                  <th class="assembly assembly_off">POSTING ASSEMBLY</th>
                  <th class="blockmuni blockmuni_temp">PRESENT BLOCK/MUNICIPALITY</th>
                  <th class="blockmuni blockmuni_perm">PERMANENT BLOCK/MUNICIPALITY</th>
                  <th class="blockmuni blockmuni_off">POSTING BLOCK/MUNICIPALITY</th>
                  <th class="edit">EDIT EMPLOYEE</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>

              </tfoot>
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <!-- Modal -->
  <div id="message-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-red-gradient">
          <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
          <h3 class="modal-title"><strong><i class="fa fa-warning text-yellow"></i></strong> Warning Message</h3>
        </div>
        <div class="modal-body">
          <h4></h4>
        </div>

      </div>

    </div>
  </div>
  <script src="js/personnel.js"></script>
  <script type="text/javascript">
    var table;
    var data_on = "<span class='badge bg-green'><i class='fa fa-check'></i></span>";
    var data_target_on = 'personal';
    var locked_data_target /*= ['personal', 'salary', 'additional']*/;
    var assembly;
    var assembly_combo;
    var blockmuni;
    var blockmuni_combo;
		var group;
    var group_combo;
    var bank;
    var bank_combo;
    var remarks;
    var remarks_combo;
    var language;
    var language_combo;
    var qualification;
    var qualification_combo;
    var employees;
    var RecordIndex;
    var edit_lock = 'OPEN';
    $(document).ready(function() {
      //$('#table_employee > thead').find('.contact, .salary, .additional, .bank, .epic, .assembly').hide();
      if (checkSubdivSession() == "TRUE") {
        if (checkOfficeSession() == "TRUE") {
          $('#show_office').html("of&nbsp;" + getOfficeNamefromSession());
          $('#div_message').hide();
          $('#show_emp_form').show();
          $('#table_employee').hide();

          loadAssemblyDetails();
          loadBlockMuniDetails();
          loadGroupDetails();
          loadBankDetails();
          loadRemarks();
          loadLanguageDetails();
          loadQualificationDetails();
          LoadEmployeebyOffice();
        } else {
          $('#div_message').show();
          $('#div_message').html("<h4>Please Set Office Code first.</h4>");
          $('#show_emp_form').hide();
        }
      } else {
        $('#div_message').show();
        $('#div_message').html("<h4>Please Set Subdivision first.</h4>");
        $('#show_emp_form').hide();
      }
    });

    function loadAssemblyDetails() {
      $('.overlay').find('small').html(' Loading Assembly Data...');
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'json/assembly_details.php',
        success: function(data) {
          assembly = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      assembly_combo = "<select class='assembly_combo'>";
      for (var i = 0; i < assembly.length; i++) {
        assembly_combo += "<option value='" + assembly[i].AssemblyCode + "'>" + assembly[i].AssemblyName + "</option>";
      }
      assembly_combo += "</select>";
    }

    function loadBlockMuniDetails() {
      $('.overlay').find('small').html(' Loading Block/Municipality Data...');
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'json/blockmuni_details.php',
        success: function(data) {
          blockmuni = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      blockmuni_combo = "<select class='blockmuni_combo'>";
      for (var i = 0; i < blockmuni.length; i++) {
        blockmuni_combo += "<option value='" + blockmuni[i].BlockMuniCode + "'>" + blockmuni[i].BlockMuniName + "</option>";
      }
      blockmuni_combo += "</select>";
    }

		function loadGroupDetails() {
      $('.overlay').find('small').html(' Loading Group Data...');

      group_combo =  "<select class='group_combo'>";
      group_combo += "<option value='A'>A</option>";
			group_combo += "<option value='B'>B</option>";
			group_combo += "<option value='C'>C</option>";
			group_combo += "<option value='D'>D</option>";
      group_combo += "</select>";
    }

    function loadBankDetails() {
      $('.overlay').find('small').html(' Loading Bank Data...');
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'json/bank_details.php',
        success: function(data) {
          bank = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      bank_combo = "<select class='bank_combo'>";
      for (var i = 0; i < bank.length; i++) {
        bank_combo += "<option value='" + bank[i].BankCode + "'>" + bank[i].BankName + "</option>";
      }
      bank_combo += "</select>";
    }

    function loadRemarks() {
      $('.overlay').find('small').html(' Loading Remarks...');
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'json/remarks_details.php',
        success: function(data) {
          remarks = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      remarks_combo = "<select class='remarks_combo'>";
      for (var i = 0; i < remarks.length; i++) {
        remarks_combo += "<option value='" + remarks[i].RemarksCode + "'>" + remarks[i].RemarksName + "</option>";
      }
      remarks_combo += "</select>";
    }

    function loadLanguageDetails() {
      $('.overlay').find('small').html(' Loading Language Details...');
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'json/language_details.php',
        success: function(data) {
          language = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      language_combo = "<select class='language_combo'>";
      for (var i = 0; i < language.length; i++) {
        language_combo += "<option value='" + language[i].LanguageCode + "'>" + language[i].Language + "</option>";
      }
      language_combo += "</select>";
    }

    function loadQualificationDetails() {
      $('.overlay').find('small').html(' Loading Remarks...');
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'json/qualification_details.php',
        success: function(data) {
          qualification = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      qualification_combo = "<select class='qualification_combo'>";
      for (var i = 0; i < qualification.length; i++) {
        qualification_combo += "<option value='" + qualification[i].QualificationCode + "'>" + qualification[i].QualificationName + "</option>";
      }
      qualification_combo += "</select>";
    }

    function LoadEmployeebyOffice() {
      $('.overlay').find('small').html(' Loading Employee Data...');
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'json/employee_by_office.php',

        success: function(data) {
          employees = JSON.parse(JSON.stringify(data));
          $('#table_employee tbody').empty();
          for (var i = 0; i < employees.length; i++) {
            var present_assembly_index = assembly.map(function(data) {
              return data.AssemblyCode;
            }).indexOf(employees[i].PresentAssembly);
            var permanent_assembly_index = assembly.map(function(data) {
              return data.AssemblyCode;
            }).indexOf(employees[i].PermanentAssembly);
            var posting_assembly_index = assembly.map(function(data) {
              return data.AssemblyCode;
            }).indexOf(employees[i].PostingAssembly);

            var present_blockmuni_index = blockmuni.map(function(data) {
              return data.BlockMuniCode;
            }).indexOf(employees[i].PresentBlockMuni);
            var permanent_blockmuni_index = blockmuni.map(function(data) {
              return data.BlockMuniCode;
            }).indexOf(employees[i].PermanentBlockMuni);
            var posting_blockmuni_index = blockmuni.map(function(data) {
              return data.BlockMuniCode;
            }).indexOf(employees[i].PostingBlockMuni);

            var bank_index = bank.map(function(data) {
              return data.BankCode;
            }).indexOf(employees[i].Bank);
            var remarks_index = remarks.map(function(data) {
              return data.RemarksCode;
            }).indexOf(employees[i].Remarks);
            var language_index = language.map(function(data) {
              return data.LanguageCode;
            }).indexOf(employees[i].Language);
            var qualification_index = qualification.map(function(data) {
              return data.QualificationCode;
            }).indexOf(employees[i].Qualification);

            $('#table_employee').find('tbody').append("<tr><td class='index empcode'>" + employees[i].PersonCode + "</td><td class='index name'>" + employees[i].OfficerName + "</td><td class='personal desg'>" + employees[i].Desg + "</td><td class='personal gender'>" + employees[i].Gender + "</td><td class='personal dob'>" + employees[i].DOB + "</td><td class='contact present_addr1'>" + employees[i].PresentAddress1 + "</td><td class='contact present_addr2'>" + employees[i].PresentAddress2 + "</td><td class='contact perm_addr1'>" + employees[i].PermanentAddress1 + "</td><td class='contact perm_addr2'>" + employees[i].PermanentAddress2 + "</td><td class='contact email'>" + employees[i].Email + "</td><td class='contact resi_no'>" + employees[i].Phone + "</td><td class='contact mob_no'>" + employees[i].Mobile + "</td><td class='salary scale'>" + employees[i].Scale + "</td><td class='salary basic_pay'>" + employees[i].BasicPay + "</td><td class='salary grade_pay'>" + employees[i].GradePay + "</td><td class='salary group'>" + employees[i].EmpGroup + "</td><td class='additional qualificationcd'>" + qualification[qualification_index].QualificationName + "</td><td class='additional workingstatus'>" + employees[i].WorkingStatus + "</td><td class='additional languagecd'>" + language[language_index].Language + "</td><td class='additional remarks'>" + remarks[remarks_index].RemarksName + "</td><td class='bank bank_cd'>" + bank[bank_index].BankName + "</td><td class='bank branchname'>" + employees[i].Branch + "</td><td class='bank branchcd'>" + employees[i].IFSC + "</td><td class='bank bank_acc_no'>" + employees[i].AccountNo + "</td><td class='epic epic_no'>" + employees[i].EPIC + "</td><td class='epic partno'>" + employees[i].PartNo + "</td><td class='epic slno'>" + employees[i].SlNo + "</td><td class='assembly assembly_temp'>" + assembly[present_assembly_index].AssemblyName + "</td><td class='assembly assembly_perm'>" + assembly[permanent_assembly_index].AssemblyName + "</td><td class='assembly assembly_off'>" + assembly[posting_assembly_index].AssemblyName + "</td><td class='blockmuni blockmuni_temp'>" + blockmuni[present_blockmuni_index].BlockMuniName + "</td><td class='blockmuni blockmuni_perm'>" + blockmuni[permanent_blockmuni_index].BlockMuniName + "</td><td class='blockmuni blockmuni_off'>" + blockmuni[posting_blockmuni_index].BlockMuniName + "</td><td class='edit'>" + "<a href='#' class='edit-link'><span class='fa fa-edit'></span> Edit</a></td></tr>");

          }
          $('.overlay').hide();
          $('.contact, .salary, .additional, .bank, .epic, .assembly, .blockmuni').hide();
          $('#table_employee').show();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });

      table = $('#table_employee').DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
      });
    }

    $('.btn-app').click(function(e) {
      e.preventDefault();
      if (edit_lock == 'OPEN') {
        var data_target = $(this).attr('data-target').toString();
        $('.btn-app').find('.icon').removeClass('text-red');
        $('.btn-app').find('span').remove();
        $(this).prepend(data_on);
        $(this).find('.icon').addClass('text-red');
        if (data_target_on != data_target) {
          $('.' + data_target_on).hide(50, "linear");
          $('.' + data_target).show();
          data_target_on = data_target;
        }
      } else {
        $('#message-modal .modal-body h4').html('Please Cencel the pending Edit Operation in this active section and then proceed !!!');
        $('#message-modal').modal();
      }
    });

    $('#table_employee tbody').on('click', '.edit-link', function(e) {
      e.preventDefault();
      //alert($(this).html());
      if (edit_lock == 'OPEN') {
        var row = $(this).closest('tr');
        var edit_cell = $(this).closest('td');
        var emp_code = $(row).find('.empcode').html().toString(); //alert(emp_code);
        RecordIndex = employees.map(function(data) {
          return data.PersonCode;
        }).indexOf(emp_code);

        if (employees[RecordIndex].PostStat == '') {
          edit_lock = 'LOCK';
          row.addClass('warning');
          $(edit_cell).html("<a href='#' class='update-link text-green'><span class='fa fa-save'></span> Save</a> &nbsp;&nbsp; <a href='#' class='cancel-link text-red'><span class='fa fa-close'></span> Cancel</a>");
          formatEditForm(data_target_on, row);
          $('.update-link').on('click', function(e) {
            e.preventDefault();
            updateData(data_target_on, row);
          });
          $('.cancel-link').on('click', function(e) {
            e.preventDefault();
            cancelDataUpdate(data_target_on, row);
          });
        } /*else if (employees[RecordIndex].PostStat != '' && locked_data_target.indexOf(data_target_on) != -1) {
          $('#message-modal .modal-body h4').html("Data Update Locked for Employee <strong class='text-green'>" + employees[RecordIndex].OfficerName + "</strong> in <strong class='text-blue'>" + data_target_on.toUpperCase() + "</strong> Details");
          $('#message-modal').modal();
        }*/ else {
          edit_lock = 'LOCK';
          row.addClass('warning');
          $(edit_cell).html("<a href='#' class='update-link text-green'><span class='fa fa-save'></span> Save</a> &nbsp;&nbsp; <a href='#' class='cancel-link text-red'><span class='fa fa-close'></span> Cancel</a>");
          formatEditForm(data_target_on, row);
          $('.update-link').on('click', function(e) {
            e.preventDefault();
            updateData(data_target_on, row);
          });
          $('.cancel-link').on('click', function(e) {
            e.preventDefault();
            cancelDataUpdate(data_target_on, row);
          });
        }
      } else {
        $('#message-modal .modal-body h4').html('Please wait for the pending Edit Operation !!!');
        $('#message-modal').modal();
      }
    });

    function formatEditForm(DataTarget, Row) {
      if (DataTarget == 'personal') {
        //Assigning Old Values;
        var officer_name = $(Row).find('.name').html().toString();
        var desg = $(Row).find('.desg').html().toString();
        var gender = $(Row).find('.gender').html().toString();
        var dob = $(Row).find('.dob').html().toString();

        //Adding Input Feilds
        $(Row).find('.name').html("<input type='text' class='name_input'\>");
        $('.name_input').val(officer_name);
        $(Row).find('.desg').html("<input type='text' class='desg_input'\>");
        $('.desg_input').val(desg);

        var gender_combo = "<select class='gender_combo'><option value='M'>M</option><option value='F'>F</option></select>";
        $(Row).find('.gender').html(gender_combo);
        $(Row).find('.gender').find('select').addClass('gender_input');
        $('.gender_input option').each(function() {
          if ($(this).val() == gender)
            $(this).attr('selected', true);
        });

        $(Row).find('.dob').html("<input type='text' class='dob_input' readonly='readonly'\>");
        $('.dob_input').val(dob);
        $('.dob_input').daterangepicker({
          singleDatePicker: true,
          showDropdowns: true,
          "locale": {
            "format": "YYYY-MM-DD"
          },
          "minDate": "1950-01-01",
          "maxDate": "1997-12-31",
          "startDate": dob

        });
      }
      if (DataTarget == 'contact') {
        //Assigning Old Values;
        var present_addr1 = $(Row).find('.present_addr1').html().toString();
        var present_addr2 = $(Row).find('.present_addr2').html().toString();
        var perm_addr1 = $(Row).find('.perm_addr1').html().toString();
        var perm_addr2 = $(Row).find('.perm_addr2').html().toString();
        var email = $(Row).find('.email').html().toString();
        var resi_no = $(Row).find('.resi_no').html().toString();
        var mob_no = $(Row).find('.mob_no').html().toString();

        //Adding Input Feilds
        $(Row).find('.present_addr1').html("<textarea rows='3' cols='10' class='present_addr1_input'>" + present_addr1 + "</textarea>");
        $(Row).find('.present_addr2').html("<textarea rows='3' cols='10' class='present_addr2_input'>" + present_addr2 + "</textarea>");
        $(Row).find('.perm_addr1').html("<textarea rows='3' cols='10' class='perm_addr1_input'>" + perm_addr1 + "</textarea>");
        $(Row).find('.perm_addr2').html("<textarea rows='3' cols='10' class='perm_addr2_input'>" + perm_addr2 + "</textarea>");
        $(Row).find('.email').html("<input type='text' class='email_input'\>");
        $('.email_input').val(email);
        $(Row).find('.resi_no').html("<input type='text' class='resi_no_input'\>");
        $('.resi_no_input').val(resi_no);
        $(Row).find('.mob_no').html("<input type='text' class='mob_no_input'\>");
        $('.mob_no_input').val(mob_no);
      }

      if (DataTarget == 'salary') {
        //Assigning Old Values;
        var scale = $(Row).find('.scale').html().toString();
        var basic_pay = $(Row).find('.basic_pay').html().toString();
        var grade_pay = $(Row).find('.grade_pay').html().toString();
        var group = employees[RecordIndex].EmpGroup;
        //Adding Input Feilds
        $(Row).find('.scale').html("<input type='text' class='scale_input'\>");
        $('.scale_input').val(scale);
        $(Row).find('.basic_pay').html("<input type='text' class='basic_pay_input'\>");
        $('.basic_pay_input').val(basic_pay);
        $(Row).find('.grade_pay').html("<input type='text' class='grade_pay_input'\>");
        $('.grade_pay_input').val(grade_pay);

        $(Row).find('.group').html(group_combo);
        $(Row).find('.group').find('select').addClass('group_input');
        $('.group_input option').each(function() {
          if ($(this).val() == group)
            $(this).attr('selected', true);
        });

      }

      if (DataTarget == 'bank') {
        //Assigning Old Values;
        var bank_cd = employees[RecordIndex].Bank;
        var branchname = $(Row).find('.branchname').html().toString();
        var branchcd = $(Row).find('.branchcd').html().toString();
        var bank_acc_no = $(Row).find('.bank_acc_no').html().toString();

        //Adding Input Feilds
        $(Row).find('.bank_cd').html(bank_combo);
        $(Row).find('.bank_cd').find('select').addClass('bank_input');
        $('.bank_input option').each(function() {
          if ($(this).val() == bank_cd)
            $(this).attr('selected', true);
        });

        $(Row).find('.branchname').html("<input type='text' class='branchname_input'\>");
        $('.branchname_input').val(branchname);
        $(Row).find('.branchcd').html("<input type='text' class='branchcd_input'\>");
        $('.branchcd_input').val(branchcd);
        $(Row).find('.bank_acc_no').html("<input type='text' class='bank_acc_no_input'\>");
        $('.bank_acc_no_input').val(bank_acc_no);

      }

      if (DataTarget == 'epic') {
        //Assigning Old Values;
        var epic_no = $(Row).find('.epic_no').html().toString();
        var partno = $(Row).find('.partno').html().toString();
        var slno = $(Row).find('.slno').html().toString();

        //Adding Input Feilds
        $(Row).find('.epic_no').html("<input type='text' class='epic_no_input'\>");
        $('.epic_no_input').val(epic_no);
        $(Row).find('.partno').html("<input type='text' class='partno_input'\>");
        $('.partno_input').val(partno);
        $(Row).find('.slno').html("<input type='text' class='slno_input'\>");
        $('.slno_input').val(slno);

      }

      if (DataTarget == 'assembly') {
        //Assigning Old Values;
        var assembly_temp = employees[RecordIndex].PresentAssembly;
        var assembly_perm = employees[RecordIndex].PermanentAssembly;
        var assembly_off = employees[RecordIndex].PostingAssembly;

        //Adding Input Feilds
        $(Row).find('.assembly_temp').html(assembly_combo);
        $(Row).find('.assembly_temp').find('select').addClass('assembly_temp_input');
        $('.assembly_temp_input option').each(function() {
          if ($(this).val() == assembly_temp)
            $(this).attr('selected', true);
        });

        $(Row).find('.assembly_perm').html(assembly_combo);
        $(Row).find('.assembly_perm').find('.assembly_combo').addClass('assembly_perm_input');
        $('.assembly_perm_input option').each(function() {
          if ($(this).val() == assembly_perm)
            $(this).attr('selected', true);
        });

        $(Row).find('.assembly_off').html(assembly_combo);
        $(Row).find('.assembly_off').find('.assembly_combo').addClass('assembly_off_input');
        $('.assembly_off_input option').each(function() {
          if ($(this).val() == assembly_off)
            $(this).attr('selected', true);
        });
      }

      if (DataTarget == 'assembly') {
        //Assigning Old Values;
        var assembly_temp = employees[RecordIndex].PresentAssembly;
        var assembly_perm = employees[RecordIndex].PermanentAssembly;
        var assembly_off = employees[RecordIndex].PostingAssembly;

        //Adding Input Feilds
        $(Row).find('.assembly_temp').html(assembly_combo);
        $(Row).find('.assembly_temp').find('select').addClass('assembly_temp_input');
        $('.assembly_temp_input option').each(function() {
          if ($(this).val() == assembly_temp)
            $(this).attr('selected', true);
        });

        $(Row).find('.assembly_perm').html(assembly_combo);
        $(Row).find('.assembly_perm').find('.assembly_combo').addClass('assembly_perm_input');
        $('.assembly_perm_input option').each(function() {
          if ($(this).val() == assembly_perm)
            $(this).attr('selected', true);
        });

        $(Row).find('.assembly_off').html(assembly_combo);
        $(Row).find('.assembly_off').find('.assembly_combo').addClass('assembly_off_input');
        $('.assembly_off_input option').each(function() {
          if ($(this).val() == assembly_off)
            $(this).attr('selected', true);
        });
      }

      if (DataTarget == 'blockmuni') {
        //Assigning Old Values;
        var blockmuni_temp = employees[RecordIndex].PresentBlockMuni;
        var blockmuni_perm = employees[RecordIndex].PermanentBlockMuni;
        var blockmuni_off = employees[RecordIndex].PostingBlockMuni;

        //Adding Input Feilds
        $(Row).find('.blockmuni_temp').html(blockmuni_combo);
        $(Row).find('.blockmuni_temp').find('select').addClass('blockmuni_temp_input');
        $('.blockmuni_temp_input option').each(function() {
          if ($(this).val() == blockmuni_temp)
            $(this).attr('selected', true);
        });

        $(Row).find('.blockmuni_perm').html(blockmuni_combo);
        $(Row).find('.blockmuni_perm').find('.blockmuni_combo').addClass('blockmuni_perm_input');
        $('.blockmuni_perm_input option').each(function() {
          if ($(this).val() == blockmuni_perm)
            $(this).attr('selected', true);
        });

        $(Row).find('.blockmuni_off').html(blockmuni_combo);
        $(Row).find('.blockmuni_off').find('.blockmuni_combo').addClass('blockmuni_off_input');
        $('.blockmuni_off_input option').each(function() {
          if ($(this).val() == blockmuni_off)
            $(this).attr('selected', true);
        });
      }

      if (DataTarget == 'additional') {
        //Assigning Old Values;
        var qualification = employees[RecordIndex].Qualification;
        var language = employees[RecordIndex].Language;
        var remarks = employees[RecordIndex].Remarks;
        var working_status = employees[RecordIndex].WorkingStatus;

        var work_combo = "<select class='work_combo'><option value='YES'>YES</option><option value='NO'>NO</option></select>";
        //Adding Input Feilds
        $(Row).find('.qualificationcd').html(qualification_combo);
        $(Row).find('.qualificationcd').find('select').addClass('qualification_input');
        $('.qualification_input option').each(function() {
          if ($(this).val() == qualification)
            $(this).attr('selected', true);
        });

        $(Row).find('.languagecd').html(language_combo);
        $(Row).find('.languagecd').find('.language_combo').addClass('language_input');
        $('.language_input option').each(function() {
          if ($(this).val() == language)
            $(this).attr('selected', true);
        });

        $(Row).find('.remarks').html(remarks_combo);
        $(Row).find('.remarks').find('.remarks_combo').addClass('remarks_input');
        $('.remarks_input option').each(function() {
          if ($(this).val() == remarks)
            $(this).attr('selected', true);
        });

        $(Row).find('.workingstatus').html(work_combo);
        $(Row).find('.workingstatus').find('.work_combo').addClass('work_input');
        $('.work_input option').each(function() {
          if ($(this).val() == working_status)
            $(this).attr('selected', true);
        });
      }
    }

    function updateData(DataTarget, Row) {
      //Assigining EmpCode
      var emp_code = $(Row).find('.empcode').html().toString();
      var result;
      if (DataTarget == 'personal') {
        //Assigning New Values;
        var officer_name = $(Row).find('.name_input').val();
        var desg = $(Row).find('.desg_input').val();
        var gender = $(Row).find('.gender_input').val();
        var dob = $(Row).find('.dob_input').val();

        if (!checkString(officer_name)) {
          $(Row).find('.name').addClass('danger');
          return false;
        }
        $(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        result = updatePersonalData(emp_code, officer_name, desg, gender, dob);
        $(Row).removeClass('warning').find('td').removeClass('danger');
        if (result == 'Success') {
          //Adding Input Values
          $(Row).find('.name').html(officer_name).addClass('success');
          $(Row).find('.desg').html(desg).addClass('success');
          $(Row).find('.gender').html(gender).addClass('success');
          $(Row).find('.dob').html(dob).addClass('success');
          employees[RecordIndex].OfficerName = officer_name;
          employees[RecordIndex].Desg = desg;
          employees[RecordIndex].Gender = gender;
          employees[RecordIndex].DOB = dob;
        } else {
          //Adding Old Values
          $(Row).find('.name').html(employees[RecordIndex].OfficerName).addClass('danger');
          $(Row).find('.desg').html(employees[RecordIndex].Desg).addClass('danger');
          $(Row).find('.gender').html(employees[RecordIndex].Gender).addClass('danger');
          $(Row).find('.dob').html(employees[RecordIndex].DOB).addClass('danger');
        }
      }

      if (DataTarget == 'contact') {
        //Assigning New Values;
        var present_addr1 = $(Row).find('.present_addr1_input').val();
        var present_addr2 = $(Row).find('.present_addr2_input').val();
        var perm_addr1 = $(Row).find('.perm_addr1_input').val();
        var perm_addr2 = $(Row).find('.perm_addr2_input').val();
        var email = $(Row).find('.email_input').val();
        var phone = $(Row).find('.resi_no_input').val();
        var mobile = $(Row).find('.mob_no_input').val();

        if (!checkformobile(mobile)) {
          $(Row).find('.mob_no').addClass('danger');
          return false;
        }

        if (!emailaddresscheck(email)) {
          $(Row).find('.email').addClass('danger');
          return false;
        }

        $(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        result = updateContactData(emp_code, present_addr1, present_addr2, perm_addr1, perm_addr2, email, phone, mobile);
        $(Row).removeClass('warning').find('td').removeClass('danger');
        if (result == 'Success') {
          //Adding Input Values
          $(Row).find('.present_addr1').html(present_addr1).addClass('success');
          $(Row).find('.present_addr2').html(present_addr2).addClass('success');
          $(Row).find('.perm_addr1').html(perm_addr1).addClass('success');
          $(Row).find('.perm_addr2').html(perm_addr2).addClass('success');
          $(Row).find('.email').html(email).addClass('success');
          $(Row).find('.resi_no').html(phone).addClass('success');
          $(Row).find('.mob_no').html(mobile).addClass('success');

          employees[RecordIndex].PresentAddress1 = present_addr1;
          employees[RecordIndex].PresentAddress2 = present_addr2;
          employees[RecordIndex].PermanentAddress1 = perm_addr1;
          employees[RecordIndex].PermanentAddress2 = perm_addr2;
          employees[RecordIndex].Email = email;
          employees[RecordIndex].Phone = phone;
          employees[RecordIndex].Mobile = mobile;
        } else {
          //Adding Old Values
          $(Row).find('.present_addr1').html(employees[RecordIndex].PresentAddress1);
          $(Row).find('.present_addr2').html(employees[RecordIndex].PresentAddress2);
          $(Row).find('.perm_addr1').html(employees[RecordIndex].PermanentAddress1);
          $(Row).find('.perm_addr2').html(employees[RecordIndex].PermanentAddress2);
          $(Row).find('.email').html(employees[RecordIndex].Email);
          $(Row).find('.resi_no').html(employees[RecordIndex].Phone);
          $(Row).find('.mob_no').html(employees[RecordIndex].Mobile);
        }
      }

      if (DataTarget == 'salary') {
        //Assigning New Values;
        var scale = $(Row).find('.scale_input').val();
        var basic_pay = $(Row).find('.basic_pay_input').val();
        var grade_pay = $(Row).find('.grade_pay_input').val();
        var group = $(Row).find('.group_input').val();

        if (!checkfornumber(basic_pay)) {
          $(Row).find('.basic_pay').addClass('danger');
          return false;
        }

        if (!checkfornumber(grade_pay)) {
          $(Row).find('.grade_pay').addClass('danger');
          return false;
        }

        $(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        result = updateSalaryData(emp_code, scale, basic_pay, grade_pay, group);
        $(Row).removeClass('warning').find('td').removeClass('danger');
        if (result == 'Success') {
          //Adding Input Values
          $(Row).find('.scale').html(scale).addClass('success');
          $(Row).find('.basic_pay').html(basic_pay).addClass('success');
          $(Row).find('.grade_pay').html(grade_pay).addClass('success');
          $(Row).find('.group').html(group).addClass('success');
          employees[RecordIndex].Scale = scale;
          employees[RecordIndex].BasicPay = basic_pay;
          employees[RecordIndex].GradePay = grade_pay;
          employees[RecordIndex].EmpGroup = group;
        } else {
          //Adding Old Values
          $(Row).find('.scale').html(employees[RecordIndex].Scale).addClass('danger');
          $(Row).find('.basic_pay').html(employees[RecordIndex].BasicPay).addClass('danger');
          $(Row).find('.grade_pay').html(employees[RecordIndex].GradePay).addClass('danger');
          $(Row).find('.group').html(employees[RecordIndex].EmpGroup).addClass('danger');
        }
      }

      if (DataTarget == 'bank') {
        //Assigning New Values;
        var bank_cd = $(Row).find('.bank_input').val();
        var branchname = $(Row).find('.branchname_input').val();
        var branchcd = $(Row).find('.branchcd_input').val();
        var bank_acc_no = $(Row).find('.bank_acc_no_input').val();

        var bank_index = bank.map(function(data) {
          return data.BankCode;
        }).indexOf(bank_cd);

        if (!checkString(branchname)) {
          $(Row).find('.branchname').addClass('danger');
          return false;
        }

        if (!checkAccNo(bank_acc_no)) {
          $(Row).find('.bank_acc_no').addClass('danger');
          return false;
        }

        $(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        result = updateBankData(emp_code, bank_cd, branchname, branchcd, bank_acc_no);
        $(Row).removeClass('warning').find('td').removeClass('danger');
        if (result == 'Success') {
          //Adding Input Values
          $(Row).find('.bank_cd').html(bank[bank_index].BankName).addClass('success');
          $(Row).find('.branchname').html(branchname).addClass('success');
          $(Row).find('.branchcd').html(branchcd).addClass('success');
          $(Row).find('.bank_acc_no').html(bank_acc_no).addClass('success');
          employees[RecordIndex].Bank = bank_cd;
          employees[RecordIndex].Branch = branchname;
          employees[RecordIndex].IFSC = branchcd;
          employees[RecordIndex].AccountNo = bank_acc_no;
        } else {
          //Adding Old Values
          var bank_index = bank.map(function(data) {
            return data.BankCode;
          }).indexOf(employees[RecordIndex].Bank);
          $(Row).find('.bank_cd').html(bank[bank_index].BankName).addClass('danger');

          $(Row).find('.branchname').html(employees[RecordIndex].Branch).addClass('danger');
          $(Row).find('.branchcd').html(employees[RecordIndex].IFSC).addClass('danger');
          $(Row).find('.bank_acc_no').html(employees[RecordIndex].AccountNo).addClass('danger');
        }
      }

      if (DataTarget == 'epic') {
        //Assigning New Values;
        var epic_no = $(Row).find('.epic_no_input').val();
        var partno = $(Row).find('.partno_input').val();
        var slno = $(Row).find('.slno_input').val();

        if (!checkfornumber(partno)) {
          $(Row).find('.partno').addClass('danger');
          return false;
        }

        if (!checkfornumber(slno)) {
          $(Row).find('.slno').addClass('danger');
          return false;
        }

        $(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        result = updateEpicData(emp_code, epic_no, partno, slno);
        $(Row).removeClass('warning').find('td').removeClass('danger');
        if (result == 'Success') {
          //Adding Input Values
          $(Row).find('.epic_no').html(epic_no).addClass('success');
          $(Row).find('.partno').html(partno).addClass('success');
          $(Row).find('.slno').html(slno).addClass('success');
          employees[RecordIndex].EPIC = epic_no;
          employees[RecordIndex].PartNo = partno;
          employees[RecordIndex].SlNo = slno;
        } else {
          //Adding Old Values
          $(Row).find('.epic_no').html(employees[RecordIndex].EPIC).addClass('danger');
          $(Row).find('.partno').html(employees[RecordIndex].PartNo).addClass('danger');
          $(Row).find('.slno').html(employees[RecordIndex].SlNo).addClass('danger');
        }
      }

      if (DataTarget == 'assembly') {
        //Assigning New Values;
        var assembly_temp = $(Row).find('.assembly_temp_input').val();
        var assembly_perm = $(Row).find('.assembly_perm_input').val();
        var assembly_off = $(Row).find('.assembly_off_input').val();

        var present_assembly_index = assembly.map(function(data) {
          return data.AssemblyCode;
        }).indexOf(assembly_temp);
        var permanent_assembly_index = assembly.map(function(data) {
          return data.AssemblyCode;
        }).indexOf(assembly_perm);
        var posting_assembly_index = assembly.map(function(data) {
          return data.AssemblyCode;
        }).indexOf(assembly_off);

        $(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        result = updateAssemblyData(emp_code, assembly_temp, assembly_perm, assembly_off);
        $(Row).removeClass('warning');
        if (result == 'Success') {
          //Adding Input Values
          $(Row).find('.assembly_temp').html(assembly[present_assembly_index].AssemblyName).addClass('success');
          $(Row).find('.assembly_perm').html(assembly[permanent_assembly_index].AssemblyName).addClass('success');
          $(Row).find('.assembly_off').html(assembly[posting_assembly_index].AssemblyName).addClass('success');
          employees[RecordIndex].PresentAssembly = assembly_temp;
          employees[RecordIndex].PermanentAssembly = assembly_perm;
          employees[RecordIndex].PostingAssembly = assembly_off;
        } else {
          //Adding Old Values
          var present_assembly_index = assembly.map(function(data) {
            return data.AssemblyCode;
          }).indexOf(employees[RecordIndex].PresentAssembly);
          var permanent_assembly_index = assembly.map(function(data) {
            return data.AssemblyCode;
          }).indexOf(employees[RecordIndex].PermanentAssembly);
          var posting_assembly_index = assembly.map(function(data) {
            return data.AssemblyCode;
          }).indexOf(employees[RecordIndex].PostingAssembly);

          $(Row).find('.assembly_temp').html(assembly[present_assembly_index].AssemblyName).addClass('danger');
          $(Row).find('.assembly_perm').html(assembly[permanent_assembly_index].AssemblyName).addClass('danger');
          $(Row).find('.assembly_off').html(assembly[posting_assembly_index].AssemblyName).addClass('danger');
        }
      }

      if (DataTarget == 'blockmuni') {
        //Assigning New Values;
        var blockmuni_temp = $(Row).find('.blockmuni_temp_input').val();
        var blockmuni_perm = $(Row).find('.blockmuni_perm_input').val();
        var blockmuni_off = $(Row).find('.blockmuni_off_input').val();

        var present_blockmuni_index = blockmuni.map(function(data) {
          return data.BlockMuniCode;
        }).indexOf(blockmuni_temp);
        var permanent_blockmuni_index = blockmuni.map(function(data) {
          return data.BlockMuniCode;
        }).indexOf(blockmuni_perm);
        var posting_blockmuni_index = blockmuni.map(function(data) {
          return data.BlockMuniCode;
        }).indexOf(blockmuni_off);

        $(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        result = updateBlockMuniData(emp_code, blockmuni_temp, blockmuni_perm, blockmuni_off);
        $(Row).removeClass('warning');
        if (result == 'Success') {
          //Adding Input Values
          $(Row).find('.blockmuni_temp').html(blockmuni[present_blockmuni_index].BlockMuniName).addClass('success');
          $(Row).find('.blockmuni_perm').html(blockmuni[permanent_blockmuni_index].BlockMuniName).addClass('success');
          $(Row).find('.blockmuni_off').html(blockmuni[posting_blockmuni_index].BlockMuniName).addClass('success');
          employees[RecordIndex].PresentBlockMuni = blockmuni_temp;
          employees[RecordIndex].PermanentBlockMuni = blockmuni_perm;
          employees[RecordIndex].PostingBlockMuni = blockmuni_off;
        } else {
          //Adding Old Values
          var present_blockmuni_index = blockmuni.map(function(data) {
            return data.BlockMuniCode;
          }).indexOf(employees[RecordIndex].PresentBlockMuni);
          var permanent_blockmuni_index = blockmuni.map(function(data) {
            return data.BlockMuniCode;
          }).indexOf(employees[RecordIndex].PermanentBlockMuni);
          var posting_blockmuni_index = blockmuni.map(function(data) {
            return data.BlockMuniCode;
          }).indexOf(employees[RecordIndex].PostingBlockMuni);

          $(Row).find('.blockmuni_temp').html(blockmuni[present_blockmuni_index].BlockMuniName).addClass('danger');
          $(Row).find('.blockmuni_perm').html(blockmuni[permanent_blockmuni_index].BlockMuniName).addClass('danger');
          $(Row).find('.blockmuni_off').html(blockmuni[posting_blockmuni_index].BlockMuniName).addClass('danger');
        }
      }

      if (DataTarget == 'additional') {
        //Assigning New Values;
        var qualification_val = $(Row).find('.qualification_input').val();
        var language_val = $(Row).find('.language_input').val();
        var remarks_val = $(Row).find('.remarks_input').val();
        var working_status = $(Row).find('.work_input').val();

        var remarks_index = remarks.map(function(data) {
          return data.RemarksCode;
        }).indexOf(remarks_val);
        var language_index = language.map(function(data) {
          return data.LanguageCode;
        }).indexOf(language_val);
        var qualification_index = qualification.map(function(data) {
          return data.QualificationCode;
        }).indexOf(qualification_val);

        $(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        result = updateAdditionalData(emp_code, qualification_val, language_val, remarks_val, working_status);
        $(Row).removeClass('warning');
        if (result == 'Success') {
          //Adding Input Values
          $(Row).find('.qualificationcd').html(qualification[qualification_index].QualificationName).addClass('success');
          $(Row).find('.languagecd').html(language[language_index].Language).addClass('success');
          $(Row).find('.remarks').html(remarks[remarks_index].RemarksName).addClass('success');
          $(Row).find('.workingstatus').html(working_status).addClass('success');

          employees[RecordIndex].Qualification = qualification_val;
          employees[RecordIndex].Language = language_val;
          employees[RecordIndex].Remarks = remarks_val;
          employees[RecordIndex].WorkingStatus = working_status;
        } else {
          //Adding Old Values
          var qualification_index = qualification.map(function(data) {
            return data.QualificationCode;
          }).indexOf(employees[RecordIndex].Qualification);
          var language_index = language.map(function(data) {
            return data.LanguageCode;
          }).indexOf(employees[RecordIndex].Language);
          var remarks_index = remarks.map(function(data) {
            return data.RemarksCode;
          }).indexOf(employees[RecordIndex].Remarks);

          $(Row).find('.qualificationcd').html(qualification[qualification_index].QualificationName).addClass('danger');
          $(Row).find('.languagecd').html(language[language_index].Language).addClass('danger');
          $(Row).find('.remarks').html(remarks[remarks_index].RemarksName).addClass('danger');
          $(Row).find('.workingstatus').html(employees[RecordIndex].WorkingStatus).addClass('danger');
        }
      }

      $(Row).find('.edit').html("<a href='#' class='edit-link'><span class='fa fa-edit'></span> Edit</a>");
      edit_lock = 'OPEN';
    }

    function cancelDataUpdate(DataTarget, Row) {
      $(Row).removeClass('warning').find('td').removeClass('danger');
      if (DataTarget == 'personal') {
        //Adding Old Values
        $(Row).find('.name').html(employees[RecordIndex].OfficerName);
        $(Row).find('.desg').html(employees[RecordIndex].Desg);
        $(Row).find('.gender').html(employees[RecordIndex].Gender);
        $(Row).find('.dob').html(employees[RecordIndex].DOB);
      }
      if (DataTarget == 'contact') {
        //Adding Old Values
        $(Row).find('.present_addr1').html(employees[RecordIndex].PresentAddress1);
        $(Row).find('.present_addr2').html(employees[RecordIndex].PresentAddress2);
        $(Row).find('.perm_addr1').html(employees[RecordIndex].PermanentAddress1);
        $(Row).find('.perm_addr2').html(employees[RecordIndex].PermanentAddress2);
        $(Row).find('.email').html(employees[RecordIndex].Email);
        $(Row).find('.resi_no').html(employees[RecordIndex].Phone);
        $(Row).find('.mob_no').html(employees[RecordIndex].Mobile);
      }

      if (DataTarget == 'salary') {
        //Adding Old Values
        $(Row).find('.scale').html(employees[RecordIndex].Scale);
        $(Row).find('.basic_pay').html(employees[RecordIndex].BasicPay);
        $(Row).find('.grade_pay').html(employees[RecordIndex].GradePay);
        $(Row).find('.group').html(employees[RecordIndex].EmpGroup);
      }

      if (DataTarget == 'bank') {
        //Adding Old Values
        var bank_index = bank.map(function(data) {
          return data.BankCode;
        }).indexOf(employees[RecordIndex].Bank);
        $(Row).find('.bank_cd').html(bank[bank_index].BankName);

        $(Row).find('.branchname').html(employees[RecordIndex].Branch);
        $(Row).find('.branchcd').html(employees[RecordIndex].IFSC);
        $(Row).find('.bank_acc_no').html(employees[RecordIndex].AccountNo);
      }

      if (DataTarget == 'epic') {
        //Adding Old Values
        $(Row).find('.epic_no').html(employees[RecordIndex].EPIC);
        $(Row).find('.partno').html(employees[RecordIndex].PartNo);
        $(Row).find('.slno').html(employees[RecordIndex].SlNo);
      }

      if (DataTarget == 'assembly') {
        //Adding Old Values
        var present_assembly_index = assembly.map(function(data) {
          return data.AssemblyCode;
        }).indexOf(employees[RecordIndex].PresentAssembly);
        var permanent_assembly_index = assembly.map(function(data) {
          return data.AssemblyCode;
        }).indexOf(employees[RecordIndex].PermanentAssembly);
        var posting_assembly_index = assembly.map(function(data) {
          return data.AssemblyCode;
        }).indexOf(employees[RecordIndex].PostingAssembly);

        $(Row).find('.assembly_temp').html(assembly[present_assembly_index].AssemblyName);
        $(Row).find('.assembly_perm').html(assembly[permanent_assembly_index].AssemblyName);
        $(Row).find('.assembly_off').html(assembly[posting_assembly_index].AssemblyName);
      }

      if (DataTarget == 'blockmuni') {
        //Adding Old Values
        var present_blockmuni_index = blockmuni.map(function(data) {
          return data.BlockMuniCode;
        }).indexOf(employees[RecordIndex].PresentBlockMuni);
        var permanent_blockmuni_index = blockmuni.map(function(data) {
          return data.BlockMuniCode;
        }).indexOf(employees[RecordIndex].PermanentBlockMuni);
        var posting_blockmuni_index = blockmuni.map(function(data) {
          return data.BlockMuniCode;
        }).indexOf(employees[RecordIndex].PostingBlockMuni);

        $(Row).find('.blockmuni_temp').html(blockmuni[present_blockmuni_index].BlockMuniName);
        $(Row).find('.blockmuni_perm').html(blockmuni[permanent_blockmuni_index].BlockMuniName);
        $(Row).find('.blockmuni_off').html(blockmuni[posting_blockmuni_index].BlockMuniName);
      }

      if (DataTarget == 'additional') {
        //Adding Old Values
        var qualification_index = qualification.map(function(data) {
          return data.QualificationCode;
        }).indexOf(employees[RecordIndex].Qualification);
        var language_index = language.map(function(data) {
          return data.LanguageCode;
        }).indexOf(employees[RecordIndex].Language);
        var remarks_index = remarks.map(function(data) {
          return data.RemarksCode;
        }).indexOf(employees[RecordIndex].Remarks);

        $(Row).find('.qualificationcd').html(qualification[qualification_index].QualificationName);
        $(Row).find('.languagecd').html(language[language_index].Language);
        $(Row).find('.remarks').html(remarks[remarks_index].RemarksName);
        $(Row).find('.workingstatus').html(employees[RecordIndex].WorkingStatus);
      }

      $(Row).find('.edit').html("<a href='#' class='edit-link'><span class='fa fa-edit'></span> Edit</a>");
      edit_lock = 'OPEN';
    }

    function updatePersonalData(EmpCode, OfficerName, Desg, Gender, dob) {
      var result;
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'personnel_update/update_personal.php',
        type: 'POST',
        data: {
          EmpCode: EmpCode,
          OfficerName: OfficerName,
          Desg: Desg,
          Gender: Gender,
          Dob: dob
        },
        success: function(data) {
          result = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      return result.Status;
    }

    function updateContactData(EmpCode, PresentAddr1, PresentAddr2, PermAddr1, PermAddr2, Email, Phone, Mobile) {
      var result;
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'personnel_update/update_contact.php',
        type: 'POST',
        data: {
          EmpCode: EmpCode,
          PresentAddr1: PresentAddr1,
          PresentAddr2: PresentAddr2,
          PermAddr1: PermAddr1,
          PermAddr2: PermAddr2,
          Email: Email,
          Phone: Phone,
          Mobile: Mobile
        },
        success: function(data) {
          result = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      return result.Status;
    }

    function updateSalaryData(EmpCode, Scale, BasicPay, GradePay, Group) {
      var result;
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'personnel_update/update_salary.php',
        type: 'POST',
        data: {
          EmpCode: EmpCode,
          Scale: Scale,
          BasicPay: BasicPay,
          GradePay: GradePay,
          EmpGroup: Group
        },
        success: function(data) {
          result = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      return result.Status;
    }

    function updateBankData(EmpCode, BankCd, BranchName, BranchCd, BankAccNo) {
      var result;
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'personnel_update/update_bank.php',
        type: 'POST',
        data: {
          EmpCode: EmpCode,
          BankCd: BankCd,
          BranchName: BranchName,
          BranchCd: BranchCd,
          BankAccNo: BankAccNo
        },
        success: function(data) {
          result = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      return result.Status;
    }

    function updateEpicData(EmpCode, EpicNo, PartNo, SlNo) {
      var result;
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'personnel_update/update_epic.php',
        type: 'POST',
        data: {
          EmpCode: EmpCode,
          EpicNo: EpicNo,
          PartNo: PartNo,
          SlNo: SlNo
        },
        success: function(data) {
          result = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      return result.Status;
    }

    function updateAssemblyData(EmpCode, AssemblyTemp, AssemblyPerm, AssemblyOff) {
      var result;
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'personnel_update/update_assembly.php',
        type: 'POST',
        data: {
          EmpCode: EmpCode,
          AssemblyTemp: AssemblyTemp,
          AssemblyPerm: AssemblyPerm,
          AssemblyOff: AssemblyOff
        },
        success: function(data) {
          result = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      return result.Status;
    }

    function updateBlockMuniData(EmpCode, BlockMuniTemp, BlockMuniPerm, BlockMuniOff) {
      var result;
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'personnel_update/update_blockmuni.php',
        type: 'POST',
        data: {
          EmpCode: EmpCode,
          BlockMuniTemp: BlockMuniTemp,
          BlockMuniPerm: BlockMuniPerm,
          BlockMuniOff: BlockMuniOff
        },
        success: function(data) {
          result = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      return result.Status;
    }

    function updateAdditionalData(EmpCode, Qualification, Language, Remarks, WorkingStatus) {
      var result;
      $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'personnel_update/update_additional_data.php',
        type: 'POST',
        data: {
          EmpCode: EmpCode,
          Qualification: Qualification,
          Language: Language,
          Remarks: Remarks,
          WorkingStatus: WorkingStatus
        },
        success: function(data) {
          result = JSON.parse(JSON.stringify(data));
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(errorThrown);
        },
        dataType: "json",
        async: false
      });
      return result.Status;
    }
  </script>
