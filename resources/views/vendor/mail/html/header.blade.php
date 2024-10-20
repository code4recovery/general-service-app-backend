@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">

            <img src="https://generalservice.app/favicon.png" alt="" class="logo">

            {{ $slot }}

        </a>
    </td>
</tr>
