@extends('masteradmin.layouts.app')
<title>Profityo | New Sales Taxes</title>
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="m-0">New Sales Taxes</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">New Sales Taxes</li>
                    </ol>
                </div>
                <div class="col-auto">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{route('business.salestax.index')}}"><button class="add_btn_br">Cancel</button></a>
                        <button type="submit" form="items-form" class="add_btn">Save</button>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content px-10">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New Sales Taxes</h3>
                </div>

                <form id="items-form" method="POST" action="{{ route('business.salestax.store') }}">
                    @csrf
                    <div class="card-body2">
                        <div class="row pad-5">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="taxname">Tax Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tax_name') is-invalid @enderror" id="taxname"
                                           name="tax_name" placeholder="Tax Name" value="{{ old('tax_name') }}">
                                    @error('tax_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="textabbreviation">Abbreviation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tax_abbreviation') is-invalid @enderror"
                                           id="textabbreviation" name="tax_abbreviation" placeholder="Abbreviation"
                                           value="{{ old('tax_abbreviation') }}">
                                    @error('tax_abbreviation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="taxnumber">Your Tax Number</label>
                                    <input type="number" class="form-control @error('tax_number') is-invalid @enderror" id="taxnumber"
                                           name="tax_number" placeholder="Your Tax Number" value="{{ old('tax_number') }}">
                                    @error('tax_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tax_number_invoices" value="on"
                                           @if(old('tax_number_invoices') == 'on') checked @endif>
                                    <label class="form-check-label">Show Tax Number on Invoices</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tax_recoverable" value="on"
                                           @if(old('tax_recoverable') == 'on') checked @endif>
                                    <label class="form-check-label">This Tax is Recoverable</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tax_compound" value="on"
                                           @if(old('tax_compound') == 'on') checked @endif>
                                    <label class="form-check-label">This is a Compound Tax</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="taxdescription">Description</label>
                                    <textarea id="taxdescription" class="form-control @error('tax_desc') is-invalid @enderror" rows="3"
                                              name="tax_desc" placeholder="Enter your text here">{{ old('tax_desc') }}</textarea>
                                    @error('tax_desc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="textrate">Tax Rate (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror"
                                           id="textrate" placeholder="0.000" value="{{ old('tax_rate') }}">
                                    @error('tax_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row py-20 px-10">
                            <div class="col-md-12 text-center">
                                <a href="{{route('business.salestax.index')}}" class="add_btn_br">Cancel</a>
                                <a href="#"><button type="submit" class="add_btn">Save</button></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection
