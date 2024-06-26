# apr/25/2016 15:38:58 by RouterOS 6.32.3
# software id = RV9Y-0FM0
#
/ip firewall filter
add action=passthrough chain=unused-hs-chain comment=\
    "place hotspot rules here" disabled=yes
add action=passthrough chain=unused-hs-chain comment=\
    "place hotspot rules here" disabled=yes
add action=passthrough chain=unused-hs-chain comment=\
    "place hotspot rules here" disabled=yes
add action=drop chain=forward comment="CLIENTES BLOQUEADOS" routing-mark=!MSG \
    src-address-list=bloqueados
add action=drop chain=output comment="CLIENTES BLOQUEADOS" routing-mark=!MSG \
    src-address-list=bloqueados
add action=drop chain=input comment="CLIENTES BLOQUEADOS" disabled=yes \
    dst-address-list=!liberados src-address-list=bloqueados
