
export function getURLParameters() {
    const searchParams = new URLSearchParams(window.location.search);
    const params = {};

    for (const [key, value] of searchParams.entries()) {
        params[key] = value;
    }

    return params;
}

export function setURLParameters(parameters) {
    const queryString = new URLSearchParams(parameters).toString();

    window.history.pushState(null, null, `?${queryString}`);
}
