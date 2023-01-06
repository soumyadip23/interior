<div class="tile">
    <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
        <tbody>
            <tr>
                <td>Email</td>
                <td><a href="mailto:{{ $userdetails->email }}">{{ $userdetails->email }}</a></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><a href="tel:{{ empty($userProfile->phone_number)? null:$userProfile->phone_number }}">{{ empty($userProfile->phone_number)? null:$userProfile->phone_number }}</a></td>
            </tr>
            <tr>
                <td>Company Name</td>
                <td>{{ empty($userProfile->company_name)? null:$userProfile->company_name }}</td>
            </tr>
            <tr>
                <td>Company Registration Number</td>
                <td>{{ empty($userProfile->company_registration_number)? null:($userProfile->company_registration_number) }}</td>
            </tr>
            <tr>
                <td>Company VAT Number</td>
                <td>{{ empty($userProfile->company_vat_number)? null:$userProfile->company_vat_number }}</td>
            </tr>
            <tr>
                <td>Postcode</td>
                <td>{{ empty($userProfile->post_code)? null:$userProfile->post_code }}</td>
            </tr>
            <tr>
                <td>Website URL</td>
                <td><a href="{{ empty($userProfile->website_url)? null:$userProfile->website_url }}" target="_blank">{{ empty($userProfile->website_url)? null:$userProfile->website_url }}</a></td>
            </tr>
        </tbody>
    </table>
</div>