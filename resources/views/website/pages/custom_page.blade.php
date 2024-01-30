@extends('layouts.master')
@section('css')
<style type="text/css">
        {!! $page->css !!}
</style>
@endsection
@section('content')
    @include('website.includes.breadcrumb',['title' => $page->title,'url'=>'#'])
    {!! $page->html !!}
@endsection
