$(document).ready(function() {
    $('#calculate-form').submit(function (e) {
        e.preventDefault();

        $.getJSON(this.action, {
            "tax": this.tax.value,
            "total_value": this.total_value.value,
            "installments": this.installments.value,
            "time": function (date) {
                let offset = date.getTimezoneOffset() * 60;
                let seconds = Math.round(date.getTime() / 1000);
                //return 1550242846;
                return seconds - offset;
            }(new Date())
        })
        .fail(function (jqxhr) {
            alert(jqxhr.responseJSON.message);
        })
        .done(function (data) {
            console.log(data);

            let headerRow = $(document.createElement('tr')).append('<td></td>').append('<td>Policy</td>');
            let valueRow = $(document.createElement('tr')).append('<td>Value</td>').append('<td>' + data.policy.total_value + '</td>');
            let premiumRow = $(document.createElement('tr')).append('<td>Base premium ' + (data.policy.premium.premium * 100) + '%</td>').append('<td>' + data.premiumTotal + '</td>');
            let commissionRow = $(document.createElement('tr')).append('<td>Commission ' + (data.policy.premium.commission * 100) + '%</td>').append('<td>' + data.commissionTotal + '</td>');
            let taxRow = $(document.createElement('tr')).append('<td>Tax ' + (data.policy.tax * 100) + '%</td>').append('<td>' + data.taxTotal + '</td>');
            let totalRow = $(document.createElement('tr')).append('<td>Total cost</td>').append('<td>' + data.totalCost + '</td>');

            $('#cost-table').empty()
                .append(headerRow)
                .append(valueRow)
                .append(premiumRow)
                .append(commissionRow)
                .append(taxRow)
                .append(totalRow)
            ;

            for (let i = 0; i < data.policy.installments; i++) {
                headerRow.append('<td>Installment ' + (i + 1) + '</td>');
                valueRow.append('<td></td>');
                premiumRow.append('<td>' + data.installments[i].premiumTotal + '</td>');
                commissionRow.append('<td>' + data.installments[i].commissionTotal + '</td>');
                taxRow.append('<td>' + data.installments[i].taxTotal + '</td>');
                totalRow.append('<td>' + data.installments[i].totalCost + '</td>');
            }
        });
    });
});
