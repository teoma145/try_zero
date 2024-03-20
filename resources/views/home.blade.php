@extends('layouts.app')
@section('content')
<h1>Tabella Attività</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Alias</th>
                <th>Lavorata</th>
                <th>Padre</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Azione</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
            @php
        $canWork = ($activity->lavorata === null || $activity->lavorata == true || $activity->padre === null || isset($parentLavorataStatus[$activity->padre]));

        $canWorkOnParentMinus1 = true;
        if ($activity->padre !== null) {
            $parentMinus1Activities = $activities->where('padre', $activity->padre - 1);
            $canWorkOnParentMinus1 = $parentMinus1Activities->every(function ($parentMinus1Activity) {
                return $parentMinus1Activity->lavorata;
            });
        }


        $isLeaf = !$activities->where('padre', $activity->id)->count();


        if ($isLeaf) {
            $siblings = $activities->where('padre', $activity->padre)->except($activity->id);
            foreach ($siblings as $sibling) {

                if ($sibling->lavorata && $sibling->id !== $activity->id && $sibling->padre === $activity->padre) {
                    $canWorkOnParentMinus1 = false;
                    break;
                }
            }
        }

        $condition = $canWork && $canWorkOnParentMinus1;
        @endphp
    <tr>
        <td>{{ $activity->id }}</td>
        <td>{{ $activity->alias }}</td>
        <td>{{ $activity->lavorata ? 'Si' : 'No' }}</td>
        <td>{{ $activity->padre }}</td>
        <td>{{ $activity->created_at }}</td>
        <td>{{ $activity->updated_at }}</td>
        <td>
            Can Work: {{ $canWork ? 'Yes' : 'No' }} | Can Work on Parent -1: {{ $canWorkOnParentMinus1 ? 'Yes' : 'No' }} | Final Condition: {{ $condition ? 'Yes' : 'No' }}

            @if ($condition)
                <a href="{{ route('lavora.attivita', ['id' => $activity->id]) }}">Lavora</a>
            @else
                Non puoi lavorare su questa attività
            @endif
        </td>
    </tr>
            @endforeach
        </tbody>
    </table>
@endsection
