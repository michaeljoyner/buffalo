<style></style>

<template>
    <div class="contact-form-outer">
        <form action="/contact" @submit.stop.prevent="submitForm" v-el:form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" v-model="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" class="form-control" name="country" v-model="country">
            </div>
            <div class="form-group">
                <label for="company">Company Name</label>
                <input type="text" class="form-control" name="company" v-model="company">
            </div>
            <div class="form-group">
                <label for="company_website">Company Website</label>
                <input type="text" class="form-control" name="company_website" v-model="company_website">
            </div>
            <div class="form-group">
                <label class="top-label" for="enquiry">Message</label>
                <textarea name="enquiry" id="enquiry" v-model="enquiry"></textarea>
            </div>
            <div class="referrers-radiobox">
                <p class="body-text prompt">How did you find us?</p>
                <input name="referrer" value="google" id="google" type="radio" v-model="referrer">
                <label class="radio-label" for="google">
                    Google
                </label>
                <input name="referrer" value="exhibition" id="exhibition" type="radio" v-model="referrer">
                <label class="radio-label" for="exhibition">
                    Exhibition
                </label>
                <input name="referrer" id="trade" value="trade" type="radio" v-model="referrer">
                <label class="radio-label" for="trade">
                    Taiwan Trade
                </label>
                <input name="referrer" id="social" value="social" type="radio" v-model="referrer">
                <label class="radio-label" for="social">
                    Social Media
                </label>
                <input name="referrer" id="other" value="other" type="radio" v-model="referrer">
                <label class="radio-label" for="other">
                    Other
                </label>
                <input class="other-referrer"
                       type="text"
                       v-model="other_ref"
                       placeholder="Please let us know how you found us."
                       v-show="referrer === 'other'">
            </div>
            <button type="submit" class="btn page-section-cta on-dark contact-submit">
                <span v-show="!sending">Send Message</span>
                <div class="spinner" v-show="sending">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </button>
        </form>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        data() {
            return {
                name: '',
                email: '',
                country: '',
                company_website: '',
                company: '',
                referrer: '',
                other_ref: '',
                enquiry: '',
                sending: false,
                spent: false
            }
        },

        ready() {
          this.resetForm();
        },

        methods: {

            submitForm() {
                this.sending = true;
                this.$http.post('/contact', this.allData())
                        .then(() => this.onSuccess())
                        .catch(() => this.onFail())
            },

            onSuccess() {
                this.sending = false;
                this.spent = true;
                this.$dispatch('user-alert', {
                    type: 'success',
                    title: 'Thanks ' + this.name,
                    text: 'Your message has been received, and we will be in touch soon if need be.',
                    confirm: true
                });
                this.resetForm();
            },

            onFail() {
                this.sending = false;
                this.$dispatch('user-alert', {
                    type: 'error',
                    title: 'Oh dear, sorry ' + this.name,
                    text: 'There was a problem getting your message through. Please try again, or contact us using our details on this page.',
                    confirm: true
                });
            },

            allData() {
                let data = JSON.parse(JSON.stringify(this.$data));
                if(data.referrer === 'other' && data.other_ref !== '') {
                    data.referrer = data.other_ref;
                }
                return data;
            },

            resetForm() {
                this.$els.form.reset();
            }
        }
    }
</script>