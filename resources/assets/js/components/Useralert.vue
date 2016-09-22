<style></style>

<template></template>

<script type="text/babel">
    module.exports = {

        events: {
            'user-alert': function({type = 'error', confirm = true, text = 'Oops. An error occured', title = 'Error'} = message) {
                swal({
                    type: message.type,
                    title: message.title,
                    text: message.text,
                    timer: 1500,
                    showConfirmButton: message.confirm
                });
            }
        }
    }
</script>