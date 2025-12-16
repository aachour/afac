<h2>Submission #{{ $submissionId }}</h2>

<table width="100%" border="1" cellpadding="8" cellspacing="0">
@foreach($displayFields as $field)
    <tr>
        <td width="30%"><strong>{{ $field['label'] }}</strong></td>
        <td style="white-space: pre-wrap;">
            {{ $field['value'] }}
        </td>
    </tr>
@endforeach
</table>
