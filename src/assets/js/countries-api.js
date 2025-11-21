/**
 * Servicio para consumir REST Countries API
 * Proporciona lista de países y gentilicios
 */

class CountriesAPI {
    constructor() {
        this.apiURL = 'https://restcountries.com/v3.1/all?fields=name,demonyms,cca2';
        this.cacheKey = 'countries_cache';
        this.cacheExpiry = 24 * 60 * 60 * 1000; // 24 horas en milisegundos
        this.countries = [];
    }

    /**
     * Obtiene los países desde la API o desde caché
     */
    async fetchCountries() {
        // Verificar si hay datos en caché válidos
        const cached = this.getFromCache();
        if (cached) {
            this.countries = cached;
            return cached;
        }

        try {
            const response = await fetch(this.apiURL);
            if (!response.ok) {
                throw new Error('Error al obtener países');
            }

            const data = await response.json();
            
            // Procesar y ordenar datos
            this.countries = data
                .map(country => ({
                    name: country.name.common,
                    official: country.name.official,
                    demonym: country.demonyms?.spa?.m || country.demonyms?.eng?.m || 'Habitante',
                    code: country.cca2
                }))
                .sort((a, b) => a.name.localeCompare(b.name, 'es'));

            // Guardar en caché
            this.saveToCache(this.countries);
            
            return this.countries;

        } catch (error) {
            console.error('Error al cargar países:', error);
            // Retornar lista básica de respaldo
            return this.getFallbackCountries();
        }
    }

    /**
     * Obtiene datos del caché si están disponibles y no han expirado
     */
    getFromCache() {
        try {
            const cached = localStorage.getItem(this.cacheKey);
            if (!cached) return null;

            const { data, timestamp } = JSON.parse(cached);
            const now = new Date().getTime();

            // Verificar si el caché ha expirado
            if (now - timestamp > this.cacheExpiry) {
                localStorage.removeItem(this.cacheKey);
                return null;
            }

            return data;
        } catch (error) {
            return null;
        }
    }

    /**
     * Guarda datos en caché
     */
    saveToCache(data) {
        try {
            const cacheData = {
                data: data,
                timestamp: new Date().getTime()
            };
            localStorage.setItem(this.cacheKey, JSON.stringify(cacheData));
        } catch (error) {
            console.warn('No se pudo guardar en caché:', error);
        }
    }

    /**
     * Lista de países de respaldo en caso de error de API
     */
    getFallbackCountries() {
        return [
            { name: 'México', demonym: 'Mexicano', code: 'MX' },
            { name: 'Estados Unidos', demonym: 'Estadounidense', code: 'US' },
            { name: 'España', demonym: 'Español', code: 'ES' },
            { name: 'Argentina', demonym: 'Argentino', code: 'AR' },
            { name: 'Brasil', demonym: 'Brasileño', code: 'BR' },
            { name: 'Colombia', demonym: 'Colombiano', code: 'CO' },
            { name: 'Chile', demonym: 'Chileno', code: 'CL' },
            { name: 'Perú', demonym: 'Peruano', code: 'PE' },
            { name: 'Venezuela', demonym: 'Venezolano', code: 'VE' },
            { name: 'Ecuador', demonym: 'Ecuatoriano', code: 'EC' }
        ].sort((a, b) => a.name.localeCompare(b.name, 'es'));
    }

    /**
     * Llena un select con la lista de países
     */
    async populateCountrySelect(selectElement, selectedValue = '') {
        const countries = await this.fetchCountries();
        
        // Limpiar opciones existentes excepto la primera (placeholder)
        selectElement.innerHTML = '<option value="">Selecciona un país</option>';

        // Agregar países como opciones
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.name;
            option.textContent = country.name;
            option.dataset.demonym = country.demonym;
            
            // Seleccionar si coincide con el valor previo
            if (selectedValue && country.name === selectedValue) {
                option.selected = true;
            }
            
            selectElement.appendChild(option);
        });
    }

    /**
     * Obtiene el gentilicio de un país específico
     */
    getDemonymByCountry(countryName) {
        const country = this.countries.find(c => c.name === countryName);
        return country ? country.demonym : '';
    }
}

/**
 * Inicializar automáticamente cuando el DOM esté listo
 */
document.addEventListener('DOMContentLoaded', function() {
    const countriesAPI = new CountriesAPI();

    // Buscar el select de país de nacimiento
    const paisNacimientoSelect = document.getElementById('pais_nacimiento');
    const nacionalidadInput = document.getElementById('nacionalidad');

    if (paisNacimientoSelect && nacionalidadInput) {
        // Guardar valor previo si existe (para edición de perfil)
        const valorPrevio = paisNacimientoSelect.value || paisNacimientoSelect.dataset.value;
        
        // Llenar el select con países
        countriesAPI.populateCountrySelect(paisNacimientoSelect, valorPrevio);

        // Auto-completar nacionalidad cuando se selecciona un país
        paisNacimientoSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const demonym = selectedOption.dataset.demonym;
            
            if (demonym && nacionalidadInput) {
                nacionalidadInput.value = demonym;
            }
        });

        // Si ya hay un país seleccionado, llenar la nacionalidad
        if (valorPrevio) {
            setTimeout(() => {
                const selectedOption = paisNacimientoSelect.options[paisNacimientoSelect.selectedIndex];
                if (selectedOption && selectedOption.dataset.demonym && !nacionalidadInput.value) {
                    nacionalidadInput.value = selectedOption.dataset.demonym;
                }
            }, 100);
        }
    }
});