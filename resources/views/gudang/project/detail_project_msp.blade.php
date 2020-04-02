@extends('template.template_admin-lte')
@section('content')

<style type="text/css">
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .select2 {
        width: 100% !important;
    }

    .inputWithIconn.inputIconBg i {
        background-color: #aaa;
        color: #fff;
        padding: 7px 4px;
        border-radius: 0 4px 4px 0;
    }

    .inputWithIconn {
        position: relative;
    }

    .inputWithIconn i {
        position: absolute;
        left: 245;
        top: 28px;
        padding: 9px 8px;
        color: #aaa;
        transition: .3s;
    }

    .modalIcon input[type=text] {
        padding-left: 40px;
    }


    .modalIcon.inputIconBg input[type=text]:focus+i {
        color: #fff;
        background-color: dodgerBlue;
    }

    .modalIcon.inputIconBg i {
        background-color: #aaa;
        color: #fff;
        padding: 7px 4px;
        border-radius: 4px 0 0 4px;
    }

    .modalIcon {
        position: relative;
    }

    .modalIcon i {
        position: absolute;
        left: 0;
        top: 24px;
        padding: 9px 8px;
        color: #aaa;
        transition: .3s;
    }
</style>

<section class="content-header">
    <h1>
        Detail Delivery Order MSP
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('project')}}"><i class="fa fa-dashboard"></i> Home </a></li>
        <li class=""><a href="{{url('inventory/do/msp')}}">Delivery Order</a></li>
        <li class="active">MSP</li>
        <li class="active">Detail</li>
    </ol>
</section>

<section class="content">

    @if (session('update'))
    <div class="alert alert-warning" id="alert">
        {{ session('update') }}
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-primary" id="alert">
        {{ session('success') }}
    </div>
    @endif

    @if (session('alert'))
    <div class="alert alert-success" id="alert">
        {{ session('alert') }}
    </div>
    @endif


    <div class="box">
        <div class="box-header with-border">
            <a href="{{url('inventory/do/msp')}}"><button class="btn btn-danger btn-sm" style="margin-bottom: 5px;width: 100px"><i class="fa fa-home"></i> Back to Home</button></a>
            <h4 class="pull-right"><b>Owner PM</b> : {{$to->name}}</h4>
            <div class="col-md-12" style="border-top: solid;border-bottom: solid;border-width: 1px;outline-color: grey">
                <div class="col-md-9">
                    <i>
                        <h4><b>{{$to->subj}} - {{$to->no_do}}</b></h4>
                    </i>
                </div>
                @if($details->status_kirim != 'DONE' && $details->status_kirim != 'SENT' || Auth::User()->email == 'dev@sinergy.co.id')
                <div class="col-md-3">
                    {{-- <a href="javascript:void(0);" style="width: 100px" id="addMorelagi" onclick="tambah_produk('{{$details->id_transaction}}','{{$details->no}}','{{$details->id_pro}}')" class="btn btn-xs btn-primary"><span class="fa fa-plus">&nbsp&nbspBarang</span></a> --}}
                    @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->email == 'budigunawan@solusindoperkasa.co.id' && $details->status_kirim == 'PM')
                    <a href="javascript:void(0);" id="addMorelagi" onclick="tambah_produk('{{$details->id_transaction}}','{{$details->no}}','{{$details->id_pro}}')"><button class="margin-top btn btn-xs btn-primary pull-right" style="width: 100px;margin-bottom: 10px"><i class="fa fa-plus"> </i>&nbsp Barang</button></a>
                    @elseif(Auth::User()->id_division == 'PMO' && $details->status_kirim == '')
                    <a href="javascript:void(0);" id="addMorelagi" onclick="tambah_produk('{{$details->id_transaction}}','{{$details->no}}','{{$details->id_pro}}')"><button class="margin-top btn btn-xs btn-primary pull-right" style="width: 100px;margin-bottom: 10px"><i class="fa fa-plus"> </i>&nbsp Barang</button></a>
                    @else
                    @endif
                </div>
                @endif
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{url('/update_delivery')}}" id="modal_pr_asset" name="modal_pr_asset">
                    @csrf
                    <input type="text" name="id_transac_edit" value="{{$cek->id_transaction}}" hidden>
                    @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->email == 'budigunawan@solusindoperkasa.co.id')
                    @if($details->status_kirim == 'PM')
                    <fieldset>
                        <div class="col-sm-7">
                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">To</label>
                                @if($cek != NULL)
                                <div class="col-sm-10">
                                    <input class="form-control" name="to_agen" id="to_agen" type="text" value="{{$cek->to_agen}}" placeholder="Enter To">
                                </div>
                                @else
                                <div class="col-sm-10">
                                    <input class="form-control" name="to_agen" id="to_agen" type="text" placeholder="Enter To">
                                </div>
                                @endif
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">From</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="from" id="from" class="form-control" value="{{$cek->from}}" placeholder="Enter From">
                                    @else
                                    <input type="text" name="from" id="from" class="form-control" placeholder="Enter From">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address">{{$cek->address}}</textarea>
                                    @else
                                    <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address"></textarea>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Fax</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="fax" id="fax" class="form-control" value="{{$cek->fax}}" placeholder="Enter Fax.">
                                    @else
                                    <input type="text" name="fax" id="fax" class="form-control" placeholder="Enter Fax.">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Attn.</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="att" id="att" class="form-control" value="{{$cek->attn}}" placeholder="Enter Attention">
                                    @else
                                    <input type="text" name="att" id="att" class="form-control" placeholder="Enter Attention">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Subj.</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <textarea type="text" name="subj" id="subj" class="form-control" placeholder="Enter Subject">{{$cek->subj}}</textarea>
                                    @else
                                    <textarea type="text" name="subj" id="subj" class="form-control" placeholder="Enter Subject"></textarea>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-8">
                                    @if($cek != NULL)
                                    <input class="form-control" id="today" value="{{$cek->date}}" type="date" name="date">
                                    @else
                                    <input class="form-control" id="todays" type="date" name="date">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">ID Project</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{$details->id_project}}" name="id_project" disabled>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">Telp</label>
                                <div class="col-sm-8">
                                    @if($cek != NULL)
                                    <input type="number" name="telp" id="telp" class="form-control" value="{{$cek->telp}}" placeholder="Enter No. Telp"><br>
                                    @if($details->status_kirim != 'kirim')
                                    <button type="submit" class="form-control btn btn-warning"><i class="fa fa-check"> </i>&nbspUpdate</button>
                                    @else
                                    @endif
                                    @else
                                    <input type="number" name="telp" id="telp" class="form-control" placeholder="Enter No. Telp">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    @else
                    <fieldset disabled>
                        <div class="col-sm-7">
                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">To</label>
                                @if($cek != NULL)
                                <div class="col-sm-10">
                                    <input class="form-control" name="to_agen" id="to_agen" type="text" value="{{$cek->to_agen}}" placeholder="Enter To">
                                </div>
                                @else
                                <div class="col-sm-10">
                                    <input class="form-control" name="to_agen" id="to_agen" type="text" placeholder="Enter To">
                                </div>
                                @endif
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">From</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="from" id="from" class="form-control" value="{{$cek->from}}" placeholder="Enter From">
                                    @else
                                    <input type="text" name="from" id="from" class="form-control" placeholder="Enter From">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address">{{$cek->address}}</textarea>
                                    @else
                                    <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address"></textarea>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Fax</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="fax" id="fax" class="form-control" value="{{$cek->fax}}" placeholder="Enter Fax.">
                                    @else
                                    <input type="text" name="fax" id="fax" class="form-control" placeholder="Enter Fax.">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Attn.</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="att" id="att" class="form-control" value="{{$cek->attn}}" placeholder="Enter Attention">
                                    @else
                                    <input type="text" name="att" id="att" class="form-control" placeholder="Enter Attention">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Subj.</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <textarea type="text" name="subj" id="subj" class="form-control" placeholder="Enter Subject">{{$cek->subj}}</textarea>
                                    @else
                                    <textarea type="text" name="subj" id="subj" class="form-control" placeholder="Enter Subject"></textarea>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-8">
                                    @if($cek != NULL)
                                    <input class="form-control" id="today" value="{{$cek->date}}" type="date" name="date">
                                    @else
                                    <input class="form-control" id="todays" type="date" name="date">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">ID Project</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{$cek->id_project}}" name="">
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">No Delivery Order</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{$to->no_do}}" name="">
                                </div>
                            </div>

                        </div>
                    </fieldset>
                    @endif

                    @elseif(Auth::User()->id_division == 'PMO')
                    @if($details->status_kirim == '')
                    <fieldset>
                        <div class="col-sm-7">
                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">To</label>
                                @if($cek != NULL)
                                <div class="col-sm-10">
                                    <input class="form-control" name="to_agen" id="to_agen" type="text" value="{{$cek->to_agen}}" placeholder="Enter To">
                                </div>
                                @else
                                <div class="col-sm-10">
                                    <input class="form-control" name="to_agen" id="to_agen" type="text" placeholder="Enter To">
                                </div>
                                @endif
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">From</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="from" id="from" class="form-control" value="{{$cek->from}}" placeholder="Enter From">
                                    @else
                                    <input type="text" name="from" id="from" class="form-control" placeholder="Enter From">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address">{{$cek->address}}</textarea>
                                    @else
                                    <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address"></textarea>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Fax</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="fax" id="fax" class="form-control" value="{{$cek->fax}}" placeholder="Enter Fax.">
                                    @else
                                    <input type="text" name="fax" id="fax" class="form-control" placeholder="Enter Fax.">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Attn.</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="att" id="att" class="form-control" value="{{$cek->attn}}" placeholder="Enter Attention">
                                    @else
                                    <input type="text" name="att" id="att" class="form-control" placeholder="Enter Attention">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Subj.</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <textarea type="text" name="subj" id="subj" class="form-control" placeholder="Enter Subject">{{$cek->subj}}</textarea>
                                    @else
                                    <textarea type="text" name="subj" id="subj" class="form-control" placeholder="Enter Subject"></textarea>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-8">
                                    @if($cek != NULL)
                                    <input class="form-control" id="today" value="{{$cek->date}}" type="date" name="date">
                                    @else
                                    <input class="form-control" id="todays" type="date" name="date">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">ID Project</label>
                                <div class="col-sm-8">
                                    <select type="text" class="form-control" placeholder="Enter ID Project" name="id_project" id="id_project">
                                        @foreach($project_id as $data)
                                        @if($cek != NULL)
                                        <option value="{{$data->id_pro}}" @if($data->id_pro === $cek->id_pro)
                                            selected
                                            @endif>{{$data->id_project}}</option>
                                        @else
                                        <option value="{{$data->id_pro}}">{{$data->id_project}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">Telp</label>
                                <div class="col-sm-8">
                                    @if($cek != NULL)
                                    <input type="number" name="telp" id="telp" class="form-control" value="{{$cek->telp}}" placeholder="Enter No. Telp"><br>
                                    @if($details->status_kirim != 'kirim')
                                    <button type="submit" class="form-control btn btn-warning"><i class="fa fa-check"> </i>&nbspUpdate</button>
                                    @else
                                    @endif
                                    @else
                                    <input type="number" name="telp" id="telp" class="form-control" placeholder="Enter No. Telp">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    @else
                    <fieldset disabled>
                        <div class="col-sm-7">
                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">To</label>
                                @if($cek != NULL)
                                <div class="col-sm-10">
                                    <input class="form-control" name="to_agen" id="to_agen" type="text" value="{{$cek->to_agen}}" placeholder="Enter To">
                                </div>
                                @else
                                <div class="col-sm-10">
                                    <input class="form-control" name="to_agen" id="to_agen" type="text" placeholder="Enter To">
                                </div>
                                @endif
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">From</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="from" id="from" class="form-control" value="{{$cek->from}}" placeholder="Enter From">
                                    @else
                                    <input type="text" name="from" id="from" class="form-control" placeholder="Enter From">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address">{{$cek->address}}</textarea>
                                    @else
                                    <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address"></textarea>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Fax</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="fax" id="fax" class="form-control" value="{{$cek->fax}}" placeholder="Enter Fax.">
                                    @else
                                    <input type="text" name="fax" id="fax" class="form-control" placeholder="Enter Fax.">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Attn.</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <input type="text" name="att" id="att" class="form-control" value="{{$cek->attn}}" placeholder="Enter Attention">
                                    @else
                                    <input type="text" name="att" id="att" class="form-control" placeholder="Enter Attention">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-2 control-label">Subj.</label>
                                <div class="col-sm-10">
                                    @if($cek != NULL)
                                    <textarea type="text" name="subj" id="subj" class="form-control" placeholder="Enter Subject">{{$cek->subj}}</textarea>
                                    @else
                                    <textarea type="text" name="subj" id="subj" class="form-control" placeholder="Enter Subject"></textarea>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-8">
                                    @if($cek != NULL)
                                    <input class="form-control" id="today" value="{{$cek->date}}" type="date" name="date">
                                    @else
                                    <input class="form-control" id="todays" type="date" name="date">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">ID Project</label>
                                <div class="col-sm-8">
                                    <select type="text" class="form-control" placeholder="Enter ID Project" name="id_project" id="id_project">
                                        @foreach($project_id as $data)
                                        @if($cek != NULL)
                                        <option value="{{$data->id_pro}}" @if($data->id_pro === $cek->id_pro)
                                            selected
                                            @endif>{{$data->id_project}}</option>
                                        @else
                                        <option value="{{$data->id_pro}}">{{$data->id_project}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-left: -12px">
                                <label class="col-sm-4 control-label">Telp</label>
                                <div class="col-sm-8">
                                    @if($cek != NULL)
                                    <input type="number" name="telp" id="telp" class="form-control" value="{{$cek->telp}}" placeholder="Enter No. Telp"><br>

                                    @else
                                    <input type="number" name="telp" id="telp" class="form-control" placeholder="Enter No. Telp">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    @endif
                    @else
                    @endif
                </form>

            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
            <form method="POST" action="{{url('/publish-status')}}">
            @csrf
                <table class="table table-bordered display no-wrap" width="100%" cellspacing="0" id="produk_do">
                    <thead>
                        <tr>
                            <th>MSPCode<div class="float-right" style="margin-right:10px">Qty</div>
                                <div class="float-right" style="margin-right:25px">Req qty</div>
                            </th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Tanggal Keluar</th>
                            @if($details->status_kirim == '' && Auth::User()->id_division == 'PMO')
                            <th>Action Stock</th>
                            @elseif($details->status_kirim == 'PM' && Auth::User()->id_position == 'ADMIN')
                            <th>Action Stock</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="products-list" name="products-list">
                        <input type="text" class="form-control hidden" name="id_transac_edit" id="id_transac_edit" value="{{$cek->id_transaction}}">
                        <input type="text" value="{{$details->no_do}}" name="no_do_publish" hidden>
                        @foreach($detail as $data)
                        <tr>
                            <td><input type="" class="id_produks" name="id_produks[]" id="id_produks[]" data-rowid="{{$data->id_product}}" value="{{$data->id_product}}" hidden>
                                {{$data->kode_barang}}
                                <div class="float-right margin-left"><input type="" name="qty_stock[]" data-rowid="{{$data->id_product}}" style="border-style: none;width: 40px" class="" value="{{$data->qty}}" readonly></div>
                                <div class="float-right" class="float-right" style="margin-right:10px">
                                <input type="" name="qty_before[]" data-rowid="{{$data->id_product}}" style="border-style: none;width: 40px" class="qty_before" value="{{$data->qty_transac}}" readonly></div>
                            </td>
                            <td>{{$data->nama}}</td>
                            <td>
                                <input type="text" class="transparant" name="unit_publish[]" value="{{$data->unit_publish}}" readonly hidden>
                                {{$data->unit}}
                            </td>
                            <td>{{$data->created_at}}</td>
                            @if(Auth::User()->id_position == 'ADMIN')
                              @if($details->status_kirim == 'PM' || $details->status_kirim == '')
                              <td>
                                  <input type="button" style="width: 50px;height: 25.2px" value="Edit" onclick="revisi('{{$data->id_detail_do_msp}}','{{$data->qty_transac}}','{{$data->id_transaction}}','{{$data->id_product}}','{{$data->id_project}}','{{$data->unit}}','{{$data->qty_sisa_submit}}')" name="" class="btn btn-xs btn-warning modal_edit" data-toggle="modal" data-target="#modal_edit">
                                  <!-- <a href="{{ url('delete_project', $data->id_detail_do_msp) }}"><input type="button" style="width: 50px;height: 25.2px" value="Delete" name="" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to delete this data?')"></a> -->
                                  <input type="button" name="" style="width: 50px;height: 25.2px" onclick="delete_product('{{$data->id_detail_do_msp}}', '{{$data->id_product}}','{{$data->qty_sisa_submit}}', '{{$data->qty_transac}}')" value="Delete" class="btn btn-xs btn-danger modal_edit" data-toggle="modal" data-target="#modal_delete">
                                
                              </td>
                              @endif
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($details->status_kirim == '' && Auth::User()->id_division == 'PMO')
                <button class="btn btn-sm btn-success" onclick="edit_product('{{$details->id_transaction}}')" type="submit">Publish</button>
                @elseif($details->status_kirim == 'PM' && Auth::User()->id_position == 'ADMIN')
                <button class="btn btn-sm btn-success" onclick="edit_product('{{$details->id_transaction}}')" type="submit">Publish</button>
                @elseif($details->status_kirim == 'kirim' && Auth::User()->id_division == 'WAREHOUSE')
                <button class="btn btn-sm btn-success" onclick="edit_product('{{$details->id_transaction}}')" type="submit">Send</button>
                @endif
                </form>
            </div>
        </div>
    </div>


    @if(Auth::User()->id_position == 'ADMIN')
    <div class="box">
        <div class="box-header">Lampiran PM</div>
        <div class="box-body">

            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered display nowrap" id="lampiran_tabel" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <!-- <th>Keterangan</th> -->
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <?php $number = 1; ?>
                        <tbody id="products-list" name="products-list">
                            @foreach($detail_c as $data)
                            <tr>
                                <td>{{$number++}}</td>
                                <td>{{$data->kode_barang}} - {{$data->nama}}</td>
                                <td>
                                    @if($data->status == 'Rev')
                                    Revisi {{$data->qty_transac}}
                                    @else
                                    {{$data->qty_transac}}
                                    @endif
                                </td>
                                <td>{{$data->unit}}</td>
                                <td>{{$data->date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="modal fade" id="modal_publish" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-sm">
                <div class="modal-body">
                    <form method="POST" action="{{url('/publish-status')}}" id="modaledit" name="modaledit">
                        @csrf
                        <input type="text" class="form-control" name="id_transac_edit" id="id_transac_edit">
                        <input type="text" class="form-control" name="id_produks_edit" id="id_produks_edit">

                        <div class="form-group">
                            <h4>Yakin Data yang Anda masukkan benar sebelum <span style="color:red">publish!</span></h4>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspCancel</button>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"> </i>&nbsp&nbspYes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_pr_product_edit" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-md">
                <div class="modal-body">
                    <form method="POST" action="{{url('/store/product/do/msp')}}" id="modal_pr_asset" name="modal_pr_asset">
                        @csrf
                        <div>
                            <input type="" name="id_transaction_product" id="id_transaction_product" value="" hidden>
                            <input type="" name="no_do_edit" id="no_do_edit" value="" hidden><input type="" name="id_pro_edit" id="id_pro_edit" hidden="">
                            <legend>Add Product</legend>

                            <table id="product-add-lagi" class="table table-bordered">
                                <input type="" name="id_pam_set" id="id_pam_set" hidden>
                                <tr class="tr-header">
                                    <th width="50%">MSP Code</th>
                                    <th width="10%">Stock</th>
                                    <th width="10%">Unit</th>
                                    <th width="15%"></th>
                                    <th width="30%">Qty</th>
                                    <th><a href="javascript:void(0);" style="font-size:18px;display: none;" id="addMorelagi"><span class="fa fa-plus"></span></a></th>
                                </tr>
                                <tr>
                                    <td style="margin-bottom: 50px;" width="200px!important">
                                        <br><select class="form-control" name="product" id="product" data-rowid="0" style="font-size: 14px">
                                            <option>-- Select Product --</option>
                                            @foreach($barang as $data)
                                            <option value="{{$data->id_product}}">{{$data->kode_barang}} - {{$data->nama}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <br>
                                        <input type="text" name="ket_aja" id="ket0" class="form-control ket" data-rowid="0" readonly>
                                    </td>
                                    <td style="margin-bottom: 50px">
                                        <br>
                                        <input type="text" class="form-control unit" placeholder="Unit" name="unit" id="unit0" data-rowid="0" readonly>
                                    </td>
                                    <td style="margin-bottom: 50px">
                                        <br>
                                        <select class="form-control unite" data-rowid="0" name="unite" id="unite" style="display: none;">
                                            <option value="" readonly>Select</option>
                                            <option value="roll">roll</option>
                                            <option value="meter">meter</option>
                                        </select>
                                    </td>
                                    <td style="margin-bottom: 50px">
                                        <br>
                                        <input type="number" class="form-control qty" placeholder="Qty" name="qty" id="qty" step="any" data-rowid="0" required>
                                    </td>
                                    <td>
                                        <a href='javascript:void(0);' class='remove'><span class='fa fa-times' style="font-size: 18px;margin-top: 20px;color: red;"></span></a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
                            <!-- <input type="button" class="btn btn-primary" name="" value="Save" id="btn-save"> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  MODAL TURUNKAN  -->
    <div class="modal fade" id="modal_tambah_meter" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Stock</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{url('/tambah_meter_do')}}">
                        @csrf

                        <div class="form-group">
                            <input type="text" id="iprom" name="iprom" hidden>
                            <input type="text" id="ipro" name="ipro" hidden>
                            <label for="">Masukkan jumlah penambahan (dalam bentuk roll)</label>
                            <input type="number" class="form-control" placeholder="Entry jumlah roll" name="jml_roll" id="jml_roll" step="any" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                            <button type="submit" class="btn btn-xs btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_add_stock" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Stock</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{url('/edit_qty_do')}}">
                        @csrf

                        <div class="form-group">
                            <input type="text" id="id_detail_do_tambah" name="id_detail_do" hidden><input type="text" id="id_transac_add" name="id_transaction_edit" hidden><input type="text" id="id_product_add" name="id_product_edit" hidden><br>
                            <label for="">Req Qty</label>
                            <input type="number" class="form-control" placeholder="Entry jumlah" name="qty_tras" id="qty_tras" required readonly>
                            <label for="">Masukkan Inputan Untuk Menambah Stock</label>
                            <input type="number" class="form-control" placeholder="Entry jumlah" name="qty_produk" id="" step="any" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                            <button type="submit" class="btn btn-xs btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_kurang_stock" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kurang Stock</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{url('/return_do_product_msp')}}">
                        @csrf

                        <div class="form-group">
                            <input type="text" id="id_detail_do_kurang" name="id_detail_do" hidden><input type="text" id="id_transac_minus" name="id_transaction_edit" hidden><input type="text" id="id_product_minus" name="id_product_edit" hidden><br>
                            <label for="">Req Qty</label>
                            <input type="number" class="form-control" placeholder="Entry jumlah" name="qty_tras_kurang" id="qty_tras_kurang" readonly>
                            <label for="">Masukkan Inputan Untuk Mengurangi Stock</label>
                            <input type="number" class="form-control" placeholder="Entry jumlah" name="qty_produk" step="any" id="qty_produk_kurang" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                            <button type="submit" class="btn btn-xs btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Revisi Stock</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{url('/revisi_stok')}}">
                        @csrf

                        <div class="form-group">
                            <input type="text" id="id_project_revisi" name="id_project_revisi" hidden><input type="text" id="id_detail_do_revisi" name="id_detail_do_revisi" hidden><input type="text" id="id_transac_revisi" name="id_transaction_revisi" hidden><input type="text" id="id_product_revisi" name="id_product_revisi" hidden>
                            <input type="number" name="qty_before_revisi" id="qty_before_revisi" step="any" >
                            <input type="number" name="qty_sisa_submit_edit" id="qty_sisa_submit_edit" step="any" >
                            <div class="form-group inputWithIconn inputIconBg">
                                <label for="">Masukkan Inputan Untuk Revisi Stock</label>
                                <input type="number" class="form-control" placeholder="Entry jumlah revisi" name="qty_revisi" step="any" id="qty_revisi" required>
                                <i class="unito" style="margin-top: -4px;margin-left: 245px" aria-hidden="true">Roll</i>
                            </div>
                            <input type="number" name="qty_akhir_revisi" step="any" id="qty_akhir_revisi" readonly>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                            <button type="submit" class="btn btn-sm btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Produk</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{url('/delete_produk')}}">
                        @csrf

                        <div class="form-group">
                            <input type="text" id="id_detail_do_delete" name="id_detail_do_delete" hidden> <input type="text" id="id_product_delete" name="id_product_delete" hidden>
                            <input type="" name="qty_before_delete" id="qty_before_delete" hidden> <input type="" name="qty_sisa_submit_delete" id="qty_sisa_submit_delete" hidden>
                            <div class="form-group inputWithIconn inputIconBg">
                                <label for="">Are You Sure to Delete this Product?</label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                            <button type="submit" class="btn btn-sm btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
@section('script')
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
    $('#lampiran_tabel').DataTable({
        "scroll-X": true,
    });

    $('#produk_do').DataTable({
        "scroll-X": true,
        "pageLength":50,
    });

    $(document).ready(function(){
        var $qty_submit = $('#qty_sisa_submit_edit'),
            $qty_awal = $('#qty_before_revisi'),
            $qty = $('#qty_revisi'),
            $new = $('#qty_akhir_revisi');

        
        $qty.on('keypress', function(e)
                    {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)){
                e.stopImmediatePropagation();
                return false;
            }       
    }).on('keyup', function(e) {
            console.log('keyup');
            if($qty_awal.val() > $qty.val()){
                if ($qty.val() == '') {
                    $new.val('');
                }else{
                    $hitung = parseFloat($qty_awal.val()) - parseFloat($qty.val());
                    $new.val(parseFloat($qty_submit.val()) + parseFloat($hitung));
                }
            } else{
                if ($qty.val() == '') {
                    $new.val('');
                }else{
                    $hitung = parseFloat($qty.val()) - parseFloat($qty_awal.val());
                    $new.val(parseFloat($qty_submit.val()) - parseFloat($hitung));
                }
            }
        
        });
    });


    $('#product').select2();

    $('#id_project').select2();

    function initproduk() {
        $('.produk').select2();
    }

    function Return(id_product, id_transaction, qty_transac, id_detail_do_msp) {
        $('#id_product_edit').val(id_product);
        $('#id_transaction_edit').val(id_transaction);
        $('#qty').val(qty_transac);
        $('#id_detail_do_edit').val(id_detail_do_msp);
    }

    function tambah_produk(id_transaction, no, id_pro) {
        $('#id_transaction_product').val(id_transaction);
        $('#no_do_edit').val(no);
        $('#id_pro_edit').val(id_pro);
    }

    function edit_product(id_transaction) {
        $('#id_transac_edit').val(id_transaction);

    }

    function tambah_meter(id_product, id_product) {
        $('#iprom').val(id_product);
        $('#ipro').val(id_product - 1);
    }

    $("#alert").fadeTo(2000, 500).slideUp(500, function() {
        $("#alert").slideUp(300);
    });

    $(document).on('click', "#addMorelagi", function(e) {
        $("#modal_pr_product_edit").modal();
        var lines = $('textarea').val().split(',');
        console.log(lines);
    });


    $(document).on('change', "select[id^='product']", function(e) {
        var rowid = $(this).attr("data-rowid");

        $.ajax({
            type: "GET",
            url: '/dropdownQty',
            data: {
                product: this.value,
            },
            success: function(result) {
                $.each(result[0], function(key, value) {
                    if (value.qty_sisa_submit == null || value.qty_sisa_submit == '0.0') {
                        $(".ket[data-rowid='" + rowid + "']").val(value.qty);
                    }else{
                        $(".ket[data-rowid='" + rowid + "']").val(value.qty_sisa_submit);
                    }
                    $(".unit[data-rowid='" + rowid + "']").val(value.unit);
                    $(".information[data-rowid='" + rowid + "']").val(value.nama);


                    if (value.unit == 'roll') {
                        $(".unite[data-rowid='" + rowid + "']").css("display", "block");

                        $(document).on('change', "select[id^='unite']", function(e) {
                            var rowid = $(this).attr("data-rowid");

                            var unite = $(".unite[data-rowid='" + rowid + "']").val();

                            console.log(unite);

                            if (unite == 'roll') {
                                $(".unit[data-rowid='" + rowid + "']").val('roll');
                            } else if (unite == 'meter') {
                                $(".unit[data-rowid='" + rowid + "']").val('meter');
                            }
                        });

                    } else {

                        $(".unite[data-rowid='" + rowid + "']").css("display", "none");
                    }
                });
            }
        });


    });

    /*  $(document).on('click', "input[id^='return']", function(e){
        var rowid = $(this).attr("data-rowid");
          $(".qty_back[data-rowid='"+rowid+"']").val('');
          $(".qty_edit[data-rowid='"+rowid+"']").css("display", "none");
          $(".qty_back[data-rowid='"+rowid+"']").css("display", "block");
          $(".qty_back[data-rowid='"+rowid+"']").prop('disabled', false);
          $(".submit-qty[data-rowid='"+rowid+"']").css("display", "block");
          $(".cancel-qty[data-rowid='"+rowid+"']").css("display", "block");
          $(".e-submit-qty[data-rowid='"+rowid+"']").css("display", "none");
          $(".e-cancel-qty[data-rowid='"+rowid+"']").css("display", "none");
          console.log(rowid)
      });

      $(document).on('click', "input[id^='edit']", function(e){
        var rowid = $(this).attr("data-rowid");
          $(".qty_edit[data-rowid='"+rowid+"']").val('');
          $(".qty_edit[data-rowid='"+rowid+"']").css("display", "block");
          $(".qty_edit[data-rowid='"+rowid+"']").prop('disabled', false);
          $(".qty_back[data-rowid='"+rowid+"']").css("display", "none");
          $(".submit-qty[data-rowid='"+rowid+"']").css("display", "none");
          $(".cancel-qty[data-rowid='"+rowid+"']").css("display", "none");
          $(".e-submit-qty[data-rowid='"+rowid+"']").css("display", "block");
          $(".e-cancel-qty[data-rowid='"+rowid+"']").css("display", "block");
          console.log(rowid)
      });*/

    $(document).on('keyup keydown', "input[id^='qty_back']", function(e) {

        var rowid = $(this).attr("data-rowid");
        $(".submit-qty[data-rowid='" + rowid + "']").prop('disabled', false);
        $(".cancel-qty[data-rowid='" + rowid + "']").prop('disabled', false);

        var qty_before = $(".qty_before[data-rowid='" + rowid + "']").val();
        console.log(qty_before);
        if ($(this).val() > parseFloat(qty_before) &&
            e.keyCode != 46 &&
            e.keyCode != 8
        ) {
            e.preventDefault();
            $(this).val(qty_before);

        }
    });

    $(document).on('click', "input[id^='edit']", function(e) {
        $("#modal_tambah_stock").modal();
        /* $(document).on('keyup keydown', "input[id^='qty_produk_tras']", function(e){ 

         var qty_produk = $("#qty_tras").val();
         console.log(qty_produk);
         if ($(this).val() > parseFloat(qty_produk)
             && e.keyCode != 46
             && e.keyCode != 8
            ) {
            e.preventDefault();     
           $(this).val(qty_produk);
           
         }

         });*/
    })

    $(document).on('click', "input[id^='return']", function(e) {
        $("#modal_tambah_stock").modal();
        $(document).on('keyup keydown', "input[id^='qty_tras_kurang']", function(e) {

            var qty_produk = $("#qty_produk_kurang").val();
            console.log(qty_produk);
            if ($(this).val() > parseFloat(qty_produk) &&
                e.keyCode != 46 &&
                e.keyCode != 8
            ) {
                e.preventDefault();
                $(this).val(qty_produk);

            }

        });
    })



    $(document).on('keyup keydown', "input[id^='qty_tras']", function(e) {

        var rowid = $(this).attr("data-rowid");

        var that = this;
        setTimeout(function() {
            $(".qty_edit_clone[data-rowid='" + rowid + "']").val(that.value);
        }, 10);

        $(".e-submit-qty[data-rowid='" + rowid + "']").prop('disabled', false);
        $(".e-cancel-qty[data-rowid='" + rowid + "']").prop('disabled', false);

        var qty_produk = $(".qty_produk[data-rowid='" + rowid + "']").val();
        console.log(qty_produk);
        if ($(this).val() > parseFloat(qty_produk) &&
            e.keyCode != 46 &&
            e.keyCode != 8
        ) {
            e.preventDefault();
            $(this).val(qty_produk);

        }

    });

    $(document).on('keyup keydown', "input[id^='qty_produk']", function(e) {
        var qty_produk = $("#qty_tras_kurang").val();
        console.log(qty_produk);
        if ($(this).val() >= parseFloat(qty_produk) &&
            e.keyCode != 46 &&
            e.keyCode != 8
        ) {
            e.preventDefault();
            $(this).val(parseFloat(qty_produk) - 0.1.toFixed(2));

        }

    });

    $(document).on('click', "input[id^='cancel-qty']", function(e) {
        var rowid = $(this).attr("data-rowid");
        $(".qty_back[data-rowid='" + rowid + "']").val('');
        $(".qty_back[data-rowid='" + rowid + "']").prop('disabled', true);
        $(".submit-qty[data-rowid='" + rowid + "']").prop('disabled', true);
        console.log(rowid)
    });

    $(document).on('click', "input[id^='e-cancel-qty']", function(e) {
        var rowid = $(this).attr("data-rowid");
        $(".qty_edit[data-rowid='" + rowid + "']").val('');
        $(".qty_edit[data-rowid='" + rowid + "']").prop('disabled', true);
        $(".e-submit-qty[data-rowid='" + rowid + "']").prop('disabled', true);
        console.log(rowid)
    });

    function getadd(id_detail_do_msp, qty_transac, id_transaction, id_product) {
        $('#id_transac_add').val(id_transaction)
        $('#id_detail_do_tambah').val(id_detail_do_msp);
        $('#qty_tras').val(parseFloat(qty_transac));
        $('#id_product_add').val(id_product);
    }

    function revisi(id_detail_do_msp, qty_transac, id_transaction, id_product, id_project, unit, qty_sisa_submit) {

        $('#id_product_revisi').val(id_product);
        $('#id_project_revisi').val(id_project);
        $('#id_transac_revisi').val(id_transaction)
        $('#id_detail_do_revisi').val(id_detail_do_msp);
        $('#qty_before_revisi').val(parseFloat(qty_transac));
        $('#qty_sisa_submit_edit').val(parseFloat(qty_sisa_submit));

        if (unit == 'roll') {
          $('.unito').text('Roll') 
        } else if (unit == 'Ea') {
          $('.unito').text('Ea')
        } else if (unit == 'Bh'){
          $('.unito').text('Bh')
        } else if (unit == 'Lgh') {
          $('.unito').text('lgh')
        } else if (unit == 'Meter') {
          $('.unito').text('Meter')
        } else if (unit == 'pcs') {
          $('.unito').text('Pcs')
        } else if (unit == 'Pack') {
          $('.unito').text('Pack')
        } else {
          $('.unito').text('Unit')
        }

        
    }

    function delete_product(id_detail_do_msp, id_product, qty_sisa_submit, qty_transac) {
        $('#id_product_delete').val(id_product);
        $('#id_detail_do_delete').val(id_detail_do_msp);
        $('#qty_before_delete').val(parseFloat(qty_transac));
        $('#qty_sisa_submit_delete').val(parseFloat(qty_sisa_submit));
    }

    function getminus(id_detail_do_msp, qty_transac, id_transaction, id_product) {
        $('#id_transac_minus').val(id_transaction)
        $('#id_detail_do_kurang').val(id_detail_do_msp);
        $('#qty_tras_kurang').val(parseFloat(qty_transac));
        $('#id_product_minus').val(id_product);
    }
    /*  $(document).on('click', "input[id^='submit-qty']", function(e){
        $.ajax({  
          url:"/return_do_product_msp",  
          method:"POST",  
          data:$('#return_produk').serialize(),  
          success:function(data)  
          { 
            swal({
                  title: "Success!",
                  text:  "You have been add product",
                  type: "success",
                  timer: 2000,
                  showConfirmButton: false
              });
                 setTimeout(function() {
                     window.location.href = window.location;
                  }, 2000);                                
          }
        });  
      });*/
</script>

@endsection