@extends('master')
@section('account','active') @section('account-show','show') @section('chart_of_account','active') @section('chart_of_account-show','show') @section('chart_of_account-create','active')
@section('content')
    {!! Form::open(['class' =>'form-sample','route' => 'chart_of_account.store','method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="page-header" id="bannerClose"><h3 class="page-title"><span class="page-title-icon bg-gradient-success text-white mr-2"><i class="mdi mdi-plus"></i></span>Chart Of Accounts</h3></div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="sister_concern_id">Sister Concern</label>
                        <select class="form-control" name="sister_concern_id" id="sister_concern_id" required>
                            <option selected disabled value="">choose an option</option>
                            @foreach($sister_concerns as $sister_concern)
                                <option value="{{ $sister_concern->id}}">{{$sister_concern->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Super Head</label>
                        <select class="form-control" name="category" id="category" required>
                            <option value="" selected disabled>Choose an option</option>
                            <option value="Non-Current Asset">Non-Current Asset</option>
                            <option value="Current Asset">Current Asset</option>
                            <option value="Non-Current Liabilities">Non-Current Liabilities</option>
                            <option value="Current Liabilities">Current Liabilities</option>
                            <option value="Income">Income</option>
                            <option value="Expense">Expense</option>
                            <option value="Equity">Equity</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="" selected disabled>Choose an option</option>
                            <option value="Head">Head</option>
                            <option value="Sub-Head">Sub Head</option>
                            <option value="Child-Head">Child Head</option>
                        </select>
                        <input type="hidden" class="form-control" id="head_id" name="head_id" required>
                    </div>
                    <div class="form-group" id="head_field" style="display:none;">
                        <label for="head">Head</label>
                        <select class="form-control head_list" name="head_name" id="head_list" required>
                            <option value="" selected disabled>Choose an option</option>
                        </select>
                    </div>
                    <div class="form-group" id="sub_head_field" style="display:none;">
                        <label for="sub_head">Sub-Head</label>
                        <select class="form-control sub_head_list" name="sub_head_name" id="sub_head_list" required>
                            <option value="" selected disabled>Choose an option</option>
                        </select>
                    </div>
                    <div class="form-group" id="head_name" style="display: none">
                        <label for="head">Head</label>
                        <input type="text" class="form-control" id="head" name="head_name" placeholder="Enter Head Name" required>
                    </div>
                    <div class="form-group" id="sub_head_name" style="display: none">
                        <label for="sub_head">Sub-Head</label>
                        <input type="text" class="form-control" id="sub_head" name="sub_head_name" placeholder="Enter Sub-Head Name" required>
                        <input type="hidden" class="form-control" id="sub_head_id" name="sub_head_id">
                    </div>
                    <div class="form-group" id="child_head_name" style="display: none">
                        <label for="sub_head">Child-Head</label>
                        <input type="text" class="form-control" id="child_head" name="child_head_name" placeholder="Enter Child-Head Name" required>
                        <input type="hidden" class="form-control" id="child_head_id" name="child_head_id">
                    </div>
                    <div class="form-group">
                        <label for="narration">Narration</label>
                        <textarea class="form-control" id="narration" name="narration" rows="5" placeholder="Enter Narration Here"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/><br/>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="submit" class="custom_button"><i class="mdi mdi-plus"></i> Create </button>
        </div>
    </div>
    {!! Form::close() !!}

    <script type="text/javascript">
        function _(x){
            return document.getElementById(x);
        }
        $(document).on('input', '#type',function (){
          let string = $(this).val();
          let sister_concern_id = $('#sister_concern_id').val();
          if(sister_concern_id == null){
              toastr.error('Select Sister Concern First');
              $('#head_name, #sub_head_name, #head_list, #category, #type, #sub_head_id').val('');
          }
          else{
              $('#head_name, #sub_head_name, #child_head, #head_list, #sub_head_id, #sub_head_list, #child_head_id').val('');
              $('#child_head, #child_head_id').val('0');
              if(string == 'Head'){
                  $('#head_list, #sub_head, #child_head, #sub_head_list').prop('required', false);
                  $('#head').prop('required', true);
                  $('#head_name').show();
                  $('#head_field, #sub_head_name, #child_head_name').hide();
                  $.ajax({
                      url : '/head_id/',
                      method : 'GET',
                      success:function(data){
                          _('head_id').value = data;
                          _('sub_head_id').value = 0;
                          _('sub_head').value = 0;
                      }
                  });
              }
              if(string == 'Sub-Head'){
                  $('#head_list, #sub_head').prop('required', true);
                  $('#head, #child_head, #sub_head_list').prop('required', false);
                  $('#head_name, #child_head_name, #sub_head_field').hide();
                  $('#head_field, #sub_head_name').show();

                  $.ajax({
                      url : '/head_names/' + sister_concern_id,
                      method : 'GET',
                      success:function(data){
                          $('#head_list').empty();
                          $('#head_list').append('<option selected disabled value="">Choose An Option</option>');
                          jQuery.each( data, function( item, value ) {
                              $('#head_list').append("<option value='" + value.head_name + "'>" + value.head_name + "</option>");
                          });
                      }
                  });
                  $.ajax({
                      url : '/sub_head_id/',
                      method : 'GET',
                      success:function(data){
                          _('sub_head_id').value = data;
                      }
                  });
              }
              if(string == 'Child-Head'){
                  $('#head_list, #child_head').prop('required', true);
                  $('#head, #sub_head').prop('required', false);
                  $('#head_name, #sub_head_name').hide();
                  $('#head_field,#sub_head_field, #child_head_name').show();
                  $.ajax({
                      url : '/head_names/' + sister_concern_id,
                      method : 'GET',
                      success:function(data){
                          $('#head_list').empty();
                          $('#head_list').append('<option selected disabled value="">Choose An Option</option>');
                          jQuery.each( data, function( item, value ) {
                              $('#head_list').append("<option value='" + value.head_name + "'>" + value.head_name + "</option>");
                          });
                      }
                  });
                  $.ajax({
                      url : '/child_head_id/',
                      method : 'GET',
                      success:function(data){
                          _('child_head_id').value = data;
                      }
                  });
              }
          }
        });
        $(document).on('input', '#category',function (){
            let string = $(this).val();
            let sister_concern_id = $('#sister_concern_id').val();
            if(sister_concern_id == null){
                toastr.error('Select Sister Concern First');
                $('#head, #sub_head, #head_list, #category, #head_type').val('');
            }
            else{
                $.ajax({
                    url : '/category_heads/' + string + '/' + sister_concern_id,
                    method : 'GET',
                    success:function(data){
                        $('#head_list').empty();
                        $('#head_list').append('<option selected disabled value="">Choose An Option</option>');
                        jQuery.each( data, function( item, value ) {
                            $('#head_list').append("<option value='" + value.head_name + "'>" + value.head_name + "</option>");
                        });
                    }
                });
            }
        });
        $(document).on('input', '#head_list',function (){
            let check = _('type').value;
            if(check != 'Child-Head'){
                let string = $(this).val();
                let sister_concern_id = $('#sister_concern_id').val();
                $.ajax({
                    url : '/heads_category/' + string + '/' + sister_concern_id,
                    method : 'GET',
                    success:function(data){
                        $("#category").val(data.category).change();
                        $('#head_id').val(data.head_id);
                        $('#head').val(data.head_name);
                    }
                });
            }
            else{
                let string = $(this).val();
                let sister_concern_id = $('#sister_concern_id').val();
                $.ajax({
                    url : '/sub_heads/' + string + '/' + sister_concern_id,
                    method : 'GET',
                    success:function(data){
                        $("#category").val(data[0].category).change();
                        $('#head_id').val(data[0].head_id);
                        $('#head').val(data[0].head_name);
                        $('#sub_head_list').empty();
                        $('#sub_head_list').append('<option selected disabled value="">Choose An Option</option>');
                        jQuery.each( data[1], function( item, value ) {
                            $('#sub_head_list').append("<option value='" + value.sub_head_name + "'>" + value.sub_head_name + "</option>");
                        });
                    }
                });
            }
        });
        $(document).on('input', '#sub_head_list',function (){
            let check = _('type').value;
            if(check == 'Child-Head'){
                let string = $(this).val();
                let sister_concern_id = $('#sister_concern_id').val();
                $.ajax({
                    url : '/sub_heads_category/' + string + '/' + sister_concern_id,
                    method : 'GET',
                    success:function(data){
                        $('#sub_head_id').val(data.sub_head_id);
                        $('#sub_head').val(data.sub_head_name);
                    }
                });
            }
        });
    </script>
@endsection
