<table>
    <thead>
        <tr>
            <th>No</th>
            <th>@lang('validation.attributes.name')</th>
            <th>@lang('validation.attributes.email')</th>
            <th>@lang('validation.attributes.phone_number')</th>
            <th>@lang('validation.attributes.verified')</th>
            <th>@lang('validation.attributes.date_of_birth')</th>
            <th>@lang('validation.attributes.gender')</th>
            <th>@lang('validation.attributes.address')</th>
            @if (config('cms.users.store_id'))
                @can ('backend users store all')
                    <th>@lang('cms::cms.store')</th>
                @endcan
            @endif
            @if (config('cms.users.balance'))
                <th>@lang('cms::cms.balance')</th>
            @endif
            @if (config('cms.users.game_token'))
                <th>@lang('validation.attributes.game_token')</th>
            @endif
            @can('backend roles')
                <th>@lang('cms::cms.roles')</th>
            @endif
            <th>@lang('validation.attributes.created_at')</th>
            <th>@lang('validation.attributes.updated_at')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $i => $user)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>{{ $user->getVerifiedName() }}</td>
                <td>{{ $user->date_of_birth }}</td>
                <td>{{ $user->gender }}</td>
                <td>{{ $user->address }}</td>
                @if (config('cms.users.store_id'))
                    @can ('backend users store all')
                        <td>{{ optional($user->store)->name }}</td>
                    @endcan
                @endif
                @if (config('cms.users.balance'))
                    <td>{{ $user->balance }}</td>
                @endif
                @if (config('cms.users.game_token'))
                    <td>{{ $user->game_token }}</td>
                @endif
                @can('backend roles')
                    <td>
                        @foreach ($user->roles as $role)
                            {{ $role->name }}
                            @if (! $loop->last), @endif
                        @endforeach
                    </td>
                @endcan
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
