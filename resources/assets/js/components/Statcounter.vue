<style></style>

<template>
    <div class="stat-counter">
        <span class="stat-number">{{ initial }}</span>
        <h3 class="stat-title">{{ statTitle }}</h3>
    </div>
</template>

<script type="text/babel">
    module.exports = {

        props: {
            initial: {
                type: Number,
                default: 0
            },
            statTitle: {
                type: String
            },
            upperVal: {
                type: Number
            },
            step: {
                type: Number
            }
        },

        ready() {
          if(this.initial < this.upperVal) {
              window.requestAnimationFrame(this.count);
          }
        },

        methods: {

            count() {
                let gap = this.upperVal - this.initial;
                let jump = gap > this.step ? this.step : gap;
                if(gap > 0) {
                    this.initial += jump;
                    window.requestAnimationFrame(this.count);
                }
            }
        }
    }
</script>