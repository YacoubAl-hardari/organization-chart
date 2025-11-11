export default function organizationChart(config, containerId) {
    return {
        containerId: containerId,
        config: config,
        chart: null,

        init() {
            this.loadHighcharts().then(() => {
                this.renderChart();
            });
        },

        async loadHighcharts() {
            // Check if Highcharts is already loaded
            if (window.Highcharts) {
                return Promise.resolve();
            }

            // Load Highcharts core
            await this.loadScript('https://code.highcharts.com/highcharts.js');
            
            // Load required modules
            await this.loadScript('https://code.highcharts.com/modules/sankey.js');
            await this.loadScript('https://code.highcharts.com/modules/organization.js');
            await this.loadScript('https://code.highcharts.com/modules/exporting.js');
            await this.loadScript('https://code.highcharts.com/modules/accessibility.js');
            await this.loadScript('https://code.highcharts.com/themes/adaptive.js');
        },

        loadScript(src) {
            return new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = src;
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            });
        },

        renderChart() {
            if (!window.Highcharts) {
                console.error('Highcharts not loaded');
                return;
            }

            this.chart = Highcharts.chart(this.containerId, {
                chart: {
                    height: this.config.height || 600,
                    inverted: this.config.inverted !== false,
                },

                title: {
                    text: this.config.title || 'Organization Chart'
                },

                accessibility: {
                    point: {
                        descriptionFormat: '{add index 1}. {toNode.name}' +
                            '{#if (ne toNode.name toNode.id)}, {toNode.id}{/if}, ' +
                            'reports to {fromNode.id}'
                    }
                },

                series: [{
                    type: 'organization',
                    name: 'Organization',
                    keys: ['from', 'to'],
                    data: this.config.data || [],
                    levels: [{
                        level: 0,
                        color: 'silver',
                        dataLabels: {
                            color: 'black'
                        },
                        height: 25
                    }, {
                        level: 1,
                        color: 'silver',
                        dataLabels: {
                            color: 'black'
                        },
                        height: 25
                    }, {
                        level: 2,
                        color: '#980104'
                    }, {
                        level: 4,
                        color: '#359154'
                    }],
                    nodes: this.config.nodes || [],
                    colorByPoint: false,
                    color: '#007ad0',
                    dataLabels: {
                        color: 'white'
                    },
                    borderColor: 'var(--highcharts-background-color, white)',
                    nodeWidth: 'auto'
                }],
                tooltip: {
                    outside: true
                },
                exporting: {
                    allowHTML: true,
                    sourceWidth: 800,
                    sourceHeight: 600
                }
            });
        },

        destroy() {
            if (this.chart) {
                this.chart.destroy();
            }
        }
    }
}

