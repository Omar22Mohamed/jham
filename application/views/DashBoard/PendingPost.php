<div class="card shadow mb-4">
  <div class="card-header py-3">
  <h6 class="m-0 font-weight-bold text-primary">Pending JOB Post</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Job Title</th>
              <th>Company</th>
              <th>Location</th>
              <th style="width:125px;">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>

          <tfoot>
            <tr>
              <th>Job Title</th>
              <th>Company</th>
              <th>Location</th>
              <th>Action</th>
            </tr>
          </tfoot>
        </table> 
    </div>
  </div>
  <!-- The Modal -->
  <div class="modal fade" id="job_info">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">JOB Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div id="data"></div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <form id="activate">
            <input type="text" name="job_id" id="job_id" style="display: none;">
          </form>
          <button type="button" class="btn btn-primary" onclick="activate()">Approved</button>
          <button type="button" class="btn btn-warning" onclick="deny()">Denied</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</div>
     <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">

  var save_method; //for save method string
  var table;
  $(document).ready(function() {
    table = $('#table').DataTable({ 
      
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      
      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "<?php echo site_url('PendingPost/ajax_list')?>",
          "type": "POST"
      },

      //Set column definition initialisation properties.
      "columnDefs": [
      { 
        "targets": [ -1 ], //last column
        "orderable": false, //set not orderable
      },
      ],

    });
  });
  function reload_table()
  {
    table.ajax.reload(null,false); //reload datatable ajax 
  }
  function view(id){
      $('#job_info').modal('show');
      
      $.ajax({
        url : "<?php echo site_url('PendingPost/get_job_data/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('#data').html(data);
          $('#job_id').val(id);
        },
        errorz: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
  }
  function activate(){
 
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('PendingPost/activate/'); ?>',
        data: $('#activate').serialize(),
        success: function(data){
          Swal.fire({
            position: 'top',
            title: 'Job Approved',
            animation: true,
            customClass: {
              popup: 'animated tada'
            }
          })
          $('#job_info').modal('hide');
          reload_table();
        }
      })

  }

  function deny(){
 
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('PendingPost/deny/'); ?>',
        data: $('#activate').serialize(),
        success: function(data){
          Swal.fire({
            position: 'top',
            title: 'Job Denied',
            animation: true,
            customClass: {
              popup: 'animated tada'
            }
          })
          $('#job_info').modal('hide');
          reload_table();
        }
      })

  }

</script>