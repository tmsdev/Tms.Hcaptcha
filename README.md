# Tms.Hcaptcha

Sick of using Google reCAPTCHA in your sites?

We too. Gladly, there is an alternative, which respects data privacy and improves performance.
This package provides a [hCaptcha](https://www.hcaptcha.com/) form element for [Neos.Form](https://github.com/neos/form) & [Neos.Form.Builder](https://github.com/neos/form-builder).

## Install

```bash
composer require tms/hcaptcha
```

## Usage

1. Create a free hCaptcha account https://dashboard.hcaptcha.com/signup
2. Get the `siteKey` and `secret` from your hCaptcha account and pass them to your `Settings.yaml`

    ```
    # Configuration/Settings.yaml
    Tms:
      Hcaptcha:
        siteKey: '%env:TMS_HCAPTCHA_SITE_KEY%'
        secret: '%env:TMS_HCAPTCHA_SECRET%'
    ```

3. Add the form element to your form configuration

    ```
    prototype(Vendor.PackageName:MyForm) < prototype(Neos.Form.Builder:Form) {
        firstPage.elements {
            hcaptcha = Tms.Hcaptcha:Captcha.Definition
        }
    }
    ```

## Acknowledgments

Development sponsored by [tms.development - Online Marketing and Neos CMS Agency](https://www.tms-development.de/)
