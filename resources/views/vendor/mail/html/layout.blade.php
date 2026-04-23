<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? config('app.name') }}</title>
</head>
<body style="margin:0; padding:0; background-color:#ffffff; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="margin:0 auto; padding:0;">

                    {{-- Header --}}
                    @isset($header)
                        {{ $header }}
                    @endisset

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 20px 25px;">
                            {{ Illuminate\Mail\Markdown::parse($slot) }}
                        </td>
                    </tr>

                    {{-- Subcopy --}}
                    @isset($subcopy)
                        <tr>
                            <td style="padding: 10px 25px; font-size: 12px; color: #555;">
                                {{ $subcopy }}
                            </td>
                        </tr>
                    @endisset

                    {{-- Footer --}}
                    @isset($footer)
                        {{ $footer }}
                    @endisset

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
