param (
    [string]$pfad
)



(Get-Acl -Path $pfad).Access