export ZSH="/var/www/.oh-my-zsh"

#POWERLEVEL9K_LEFT_PROMPT_ELEMENTS=(context dir vcs)
ZSH_THEME="powerlevel10k/powerlevel10k"
plugins=(git)
source $ZSH/oh-my-zsh.sh
# To customize prompt, run `p10k configure` or edit ~/.p10k.zsh.
[[ ! -f ~/.p10k.zsh ]] || source ~/.p10k.zsh