@extends('layouts.master')
 
@section('content')
 
<h1>Editing "{{ $task->title }}"</h1>
<p class="lead">Edit and save this task below, or <a href="{{ route('tasks.index') }}">go back to all tasks.</a></p>
<hr>
 
@include('partials.alerts.errors')
 
{!! Form::model($task, [
    'method' => 'PATCH',
    'route' => ['tasks.update', $task->id]
]) !!}
 
<div class="form-group">
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>
 
<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>
 
{!! Form::submit('Update Task', ['class' => 'btn btn-primary']) !!}
 
{!! Form::close() !!}
 
@stop