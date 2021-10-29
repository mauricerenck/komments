<template>
    <div class="k-support">
        <div v-if="hasError" class="error">
            <k-info-field
                theme="negative"
                label="Ooops"
                text="The current version could not be fetched. You may have reached an API limit"
            />
        </div>
        <div v-else class="versionBox">
            <div v-if="hasVersionDiff">
                <h4 class="update-available">There is an update available</h4>
                <h3 class="version">{{ this.releaseInfo }}</h3>
            </div>
            <div v-else>
                <h4>Your Komments plugin is up to date</h4>
            </div>
            <small class="align-center">Your installed version is {{ this.version }}</small>
        </div>
    </div>
</template>

<script>
import semver from 'semver'
export default {
    data() {
        return {
            version: '',
            releaseInfo: 0,
            hasVersionDiff: false,
            hasError: false,
        }
    },
    created() {
        this.load()
    },
    computed: {},
    methods: {
        load() {
            this.$api
                .get('komments/version')
                .then(plugin => {
                    this.version = plugin.version
                })
                .then(() => {
                    fetch('https://repo.packagist.org/p/mauricerenck/komments.json', {
                        method: 'GET',
                    })
                        .then(response => response.json())
                        .then(response => {
                            if (response.status === 'error') {
                                this.hasError = true
                            }
                            this.releaseInfo = this.version
                            const latest = this.version
                            Object.keys(response.packages['mauricerenck/komments'])
                                .sort()
                                .forEach(version => {
                                    if (!semver.valid(version)) {
                                        return false
                                    }
                                    if (semver.gt(version, latest)) {
                                        this.hasVersionDiff = semver.gt(version, latest)
                                        this.releaseInfo = version.toString()
                                    }
                                })
                        })
                        .catch(error => {
                            console.log('catch', error)
                            this.hasError = true
                        })
                })
        },
    },
}
</script>

<style>
.versionBox {
    position: relative;
    padding: 1rem;
    background: #fff;
    box-shadow: var(--box-shadow-item);
    text-align: center;
}
.version {
    font-size: var(--font-size-monster);
    padding: 0.5em 0;
}
.update-available {
    color: var(--color-positive);
}
.align-center {
    display: block;
    text-align: center;
}
.k-headline-field {
    margin-bottom: 1em;
}
</style>
