import React, { Component } from 'react';
import './style.css';

class DirectoryProfile extends Component {
  static slug = 'hpde_directory_profile';

  render() {
    const { stateOptions, ageOptions, specialityOptions, state, ages, specialities } = this.props;
    return (
      <div className="profile-list-module">
        <div className="profile-list-field">
          <label htmlFor="state">State</label>
          <select 
            className="select-directory" 
            // Initial value for compatibility with Divi Builder
            defaultValue={state || ''}
            onChange={(e) => this.props.setFieldValue('state', e.target.value)}
          >
            <option>Alabama</option>
            {stateOptions && stateOptions.map(option => (
              <option key={option.value} value={option.value}>
                {option.name}
              </option>
            ))}
          </select>
        </div>

        <div className="profile-list-field">
          <label htmlFor="ages">Age</label>
          <select 
            className="select-directory" 
            defaultValue={ages || ''} 
            onChange={(e) => this.props.setFieldValue('ages', e.target.value)}
          >
            <option>Adult (19-69)</option>
            {ageOptions && ageOptions.map(option => (
              <option key={option.value} value={option.value}>
                {option.name}
              </option>
            ))}
          </select>
        </div>

        <div className="profile-list-field">
          <label htmlFor="specialities">Specialities</label>
          <select 
            className="select-directory" 
            defaultValue={specialities || ''} 
            onChange={(e) => this.props.setFieldValue('specialities', e.target.value)}
          ><option>Autoimmune Disease</option>
            {specialityOptions && specialityOptions.map(option => (
              <option key={option.value} value={option.value}>
                {option.name}
              </option>
            ))}
          </select>
        </div>
        
        <div className="flex flex-col justify-between sm:flex-row mt-4 mb-4 p-4 bg-white rounded-xl">
            <div className="hidden w-medium min-w-fit items-center justify-center pr-4 sm:flex w-20 sm:items-start">
            <img className="h-40 mt-1 rounded-full w-40 object-cover" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJQAAACUCAMAAABC4vDmAAAAMFBMVEXk5ueutLeor7Lf4ePn6eqrsbW5vsHIzM7a3d60ur3BxsjR1NbN0dPX2tzr7O29wsX2DjRMAAADaUlEQVR4nO2bW3LkIAwADYi3be5/25iZZB4bxyDZgqkt+ivZn+0SQgahTNNgMBgMBoPBYDAYDAaDwWCaAGBSG/mn3i53AFQMxt8xdpm6ewE466XU4getpZlVVy9YjHgKPcRE6Ke1KclfRnct2UkLprATpWe05g5W4PzfShmZVHOneGh0D1ZjK5j/yKZ3lpZLCPZ46R7Bcu2sKuN0i1Uzp1gXpxvN8qpeSQjTyMkgAiV0aJFWMGOctnrVpLZXJ/k3DRYQAi5Q2wJGdqkFqZThXj98oHKouK2wGZVhzqra78s/oXK8VobgxF2rHMVpY+WUipSU2goo5/pBoqTUtn6cZ+OV5sScVLTV4y0Kjhgp4fmOVajT3TuMUshTyxPG8kmr5xnGmnBCiu8C8b9JMS7fRyY6vSQwSi0fWDwn9YmfGaBKBUap1dOctGU8JVC3H29LaCGePHnvWKT104lVCgIpUMwXd1JR4KxSGcr+Y917NwhFXTIrTYQ7coNeHjhsVnFnVGZFtTyZL6IPFM7Js/YRfgBcWWduAz2sEN082e55prrPwV+iXii89T3i1NKp8tWhzWsDzqpxnDKlO6AW7J3q38BymFjSdHlvP3pu12LuYHRjdUHuaWlhew5xgApe6Fex7RffLUoPrWmxRkipM1KKNLv+IzjfuBjnuOTv3GcYAawvQN8Rqvy/K7dEG5L5Po4ak4KdF9dpvAtWtdhkvL5l02ue538RPoWoYG0oBpOKQUh9WNJz3pvZqSYRg9VZL3bL017B8iFyxwsmZ2uFniFLC2MpBYh7024VWt4yVQpQ9jiLDr1kYGhaHw+71WiJdHGTaosSMpP2kOnKWwTMlWfyAvq63ic4T+2//ta66L4M9iqju1Y6Xx+Kk5N4q9NTJhDP7bl9rZOZZS/Lple2S8UJJ+IYQhEt6ImF7EShoJasq1P8DeIjBGecMoRYAbeT0Ohsh8Cy797AdmjpT9gItEEtIL4vTULiPoTEx0YsGpHslLlJGr5eqs3iZRCN2tTKSVTPMNGnDwjoVPcgQX1SJ1pVherE7AhJqq6t3Wzr3amq67hHqvPImtMxceiVjimn+koaWT5DTaq3zahMcf2A8ucC5yhXdfqEG51UWrx23+InvphSLb97PxQz3cv2FN++VQeKyzcYDAaDwaA9XxcLKh2A6JUdAAAAAElFTkSuQmCC" alt="jon doe" />
          </div>
              <div className="flex w-full flex-col w-75 w-80">
                <div className="mb-4 mt-4 flex flex-row items-center justify-start sm:mb-0 sm:mt-0 sm:h-[100px] sm:justify-between sm:pr-6">
                  <div className="flex w-full gap-6">
                    <div className="flex flex-col justify-center">
                      <p className="font-manrope text-xl font-bold text-gray-900 sm:text-2xl">Jon Doe</p>
                      <p className="text-base font-light uppercase text-gray-500 sm:text-lg"></p>
                    </div>
                  </div>
                  <div className="btn-see-profile hidden h-fit w-fit items-center gap-1 rounded-lg border py-1 pl-2 pr-1 text-sm font-semibold text-cobalt sm:flex sm:gap-3 sm:py-2 sm:pl-4 sm:pr-2 sm:text-base">
                  See profile
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" className="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
                  </svg>
                  </div>
                </div>
                <div className="mt-4 flex flex-col">
                  <h2 className="mb-2 font-manrope text-base font-bold">Age ranges</h2>					
                    <div className="flex flex-wrap">
                      <div className="mb-2 mr-2 rounded-full px-3 py-1 text-xs font-semibold text-white bg-[#15435a66]">Pediatric (2-11)</div>
                      <div className="mb-2 mr-2 rounded-full px-3 py-1 text-xs font-semibold text-white bg-[#15435a66]">Adolescent (12-18)</div>
                      <div className="mb-2 mr-2 rounded-full px-3 py-1 text-xs font-semibold text-white bg-[#15435a66]">Adult (19-69)</div>
                    </div>
                </div>
                <div className="mt-4 flex flex-col">
                  <h2 className="mb-2 font-manrope text-base font-bold">Specialities</h2>					
                    <div className="flex flex-wrap" id="tags-container">
                        <div className="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1.5 text-xs font-semibold text-white tag-item">PCOS</div>
                        <div className="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1.5 text-xs font-semibold text-white tag-item">Tube Feeding</div>
                        <div className="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1.5 text-xs font-semibold text-white tag-item">Anti-Inflammatory Diet</div>
                        <div className="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1.5 text-xs font-semibold text-white tag-item">Candida Overgrowth</div>
                        <div className="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1.5 text-xs font-semibold text-white tag-item">Other</div>
                        <div className="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1.5 text-xs font-semibold text-white tag-item">HAES</div>
                        <div className="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1.5 text-xs font-semibold text-white tag-item">Kcal/Macro Guidance</div>
                        <div className="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1.5 text-xs font-semibold text-white tag-item">Functional/Holistic Nutrition</div>
                        <div className="flex cursor-pointer items-center text-sm text-gray-500 underline hover:opacity-80" >Show more</div>						
                  </div>
                </div>
              </div>
          </div>    
      </div>        
    );
  }
}

export default DirectoryProfile;
