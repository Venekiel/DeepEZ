import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [ "source" ]
    copy() {
        // Find out if we can write securly on the clipboard
        navigator.permissions.query({name: "clipboard-write"}).then(result => {
            if (result.state == "granted" || result.state == "prompt") {
                // Copy the text from the text field
                navigator.clipboard.write(this.sourceTarget.value);
            } else {
                // use a workaround
                this.sourceTarget.select();

                let isPassword = false;
                if (this.sourceTarget.getAttribute("type") === "password") {
                    isPassword = true; 
                    this.sourceTarget.setAttribute("type", "text");
                }

                document.execCommand("copy");

                if (isPassword) {
                    this.sourceTarget.setAttribute("type", "password");
                }
            }
        });

        alert("Successfully copied to clipboard!");
    }
}
