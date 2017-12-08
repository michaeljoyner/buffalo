<style></style>

<template>
    <div class="stat-counter">
        <span class="stat-number">{{ counter }}</span>
        <h3 class="stat-title">{{ statTitle }}</h3>
    </div>
</template>

<script type="text/babel">
    export default {

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
        data() {
          return {
              counter: this.initial
          };
        },

        mounted() {
          if(this.initial < this.upperVal) {
              window.requestAnimationFrame(this.count);
          }
        },

        methods: {

            count() {
                let gap = this.upperVal - this.counter;
                let jump = gap > this.step ? this.step : gap;
                if(gap > 0) {
                    this.counter += jump;
                    window.requestAnimationFrame(this.count);
                }
            }
        }
    }
</script>